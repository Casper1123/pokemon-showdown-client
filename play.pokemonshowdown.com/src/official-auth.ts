import type {PSUser} from "./client-main";

export class OfficialAuthError extends Error {
	constructor(operation: string, statusCode: number | null = null) {
		super(`Official auth error in operation '${operation}'.` + statusCode !== null ? ` Status code: ${statusCode!.toString()}` : "");
		this.name = 'OfficialAuthError';
		Object.setPrototypeOf(this, OfficialAuthError.prototype);
	}
}

/**
 * Quick and dirty interface draft; methods to place requests are located here.
 * Please check pre and post conditions.
 */
export const OfficialAuth = new class {
	apiUrl = "play.pokemonshowdown.com/api/oauth/";
	clientId = ""; // Todo: fill in once received.
	redirectURI = "";

	/**
	 * Returns a new URL object with the given api endpoint.
	 * @param endpoint The endpoint to reach, directly behind oauth.
	 * @pre endpoint is of type string with length >= 0, whose first character may not be /
	 * @post a new URL object containing the API url appended by the given endpoint.
	 */
	requestUrl(endpoint: string): URL {
		console.assert(endpoint.length >= 0, "No endpoint given");
		console.assert(!endpoint.startsWith("/"), "Endpoint starts with /");
		return new URL(this.apiUrl + endpoint);
	}

	/**
	 * Refreshes the currently stored auth token in cookies.
	 * Returns false if no token was found, or it already expired.
	 * True if operation succeeded.
	 */
	async refreshToken(): Promise<boolean> {
		const token = localStorage.getItem("ps-token");
		if (!token) {
			return false;
		}
		const tokenExpiry = Number(localStorage.getItem("ps-token-expiry"));
		if (!tokenExpiry) {
			return false;
		}
		const now = Date.now();
		if (tokenExpiry >= now){
			return false; // Equal because it takes a tiny bit of time to send and process the request. Might not even be large enough a buffer.
		}

		const response = await fetch(this.requestUrl("api/refreshtoken"), {
			method: "POST",
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded',
			},
			body: new URLSearchParams({
				client_id: this.clientId,
				token: token,
			})
		})

		const responseText = await response.text();
		// Remove the ']' CSRF protection prefix
		const jsonData = responseText.startsWith(']') ? responseText.slice(1) : responseText;
		const data = JSON.parse(jsonData);

		if (!data.success) {
			throw new OfficialAuthError(`refreshToken`, data.status);
		}

		localStorage.setItem("ps-token", data.success);

		console.assert(data.expires !== undefined, "No token expiry given.");
		console.assert(typeof data.expires === "number", "Token expiry is not a number:" + data.expires);

		localStorage.setItem("ps-token-expiry", data.expires);
		return true;
	}

	/**
	 * Requests authorization from the user by opening a popup to the documentation defined endpoint.
	 * Will log in the user once it's done.
	 * @param user The user to authorize.
	 */
	authorize(user: PSUser): void {
		const authorizeUrl = this.requestUrl("authorize");
		authorizeUrl.searchParams.append('redirect_uri', this.redirectURI);
		authorizeUrl.searchParams.append('client_id', this.clientId);
		authorizeUrl.searchParams.append('challenge', user.challstr);

		const popup = window.open(authorizeUrl, undefined, 'popup=1');
		const checkIfUpdated = () => {
			try {
				if (popup?.closed) { return null; } // Give up.
				else if (popup?.location?.href?.startsWith(this.redirectURI)) {
					const url = new URL(popup.location.href);
					const token = url.searchParams.get('token');
					if (!token) {
						console.error('Received no token')
						return;
					}
					localStorage.setItem('ps-token', token);

					const tokenExpiry = url.searchParams.get('expires');
					if (!tokenExpiry) {
						console.error('Received no token expiry');
						return;
					}
					// @ts-ignore if an expiry timestamp has been received, it's safe to assume it's a number. If not, make an issue here: https://github.com/smogon/pokemon-showdown-loginserver
					localStorage.setItem('ps-token-expiry', Number(tokenExpiry))

					const assertion = url.searchParams.get('assertion');
					if (!assertion) {
						console.error('Received no assertion');
						return;
					}
					popup.close();
					user.handleAssertion(user.name, assertion);
				} else {
					setTimeout(checkIfUpdated, 500);
				}
			} catch (DOMException) {
				setTimeout(checkIfUpdated, 500);
			}
		};
		checkIfUpdated();
	}

	/**
	 * Returns an assertion for the given user if there's a valid token.
	 * Otherwise returns an empty string.
	 */
	async getAssertion(user: PSUser): Promise<string | null> {
		if (!await this.authorized()) {
			return null;
		}
		const token = localStorage.getItem("ps-token");
		console.assert(token !== null, "Token was null during getAssertion call.");
		// Due to authorized call we can assume a valid token.

		const response = await fetch(this.requestUrl("api/getassertion"), {
			method: "POST",
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded',
			},
			body: new URLSearchParams({
				client_id: this.clientId,
				challenge: user.challstr,
				token: token as string, // Casting because token === null is excluded by Authorized.
			})
		})

		const responseText = await response.text();
		// Remove the ']' CSRF protection prefix
		const jsonData = responseText.startsWith(']') ? responseText.slice(1) : responseText;
		const data = JSON.parse(jsonData);
		// oauth/api/getassertion: { success: false } | string
		if (typeof data !== "string") {
			throw new OfficialAuthError(`getAssertion`, data.status);
		}
		return data; // This is our assertion!
	}

	clearTokenStorage() {
		localStorage.removeItem("ps-token");
		localStorage.removeItem("ps-token-expiry");
	}

	/**
	 * True if a valid token is in storage, false if the user must re-authorize due to lack of valid token credentials.
	 */
	async authorized(): Promise<boolean> {
		const token = localStorage.getItem("ps-token");
		const tokenExpiry_string = localStorage.getItem("ps-token-expiry");
		let refresh = false;
		let reauth = false;
		if (!token) {
			reauth = true;
		} else if (!tokenExpiry_string) {
			refresh = true;
		}

		try {
			const tokenExpiry = Number(tokenExpiry_string);
			if (tokenExpiry <= Date.now()) {
				refresh = true;
			}
		} catch (e) { reauth = true; } // If it fails, well be damned we should probably just try from scratch.

		if (refresh && !reauth) { // Skip if reauth because it's already been determined to not be a good idea.
			const success = await this.refreshToken();
			if (!success) {
				reauth = true;
			}
		}

		if (reauth) {
			this.clearTokenStorage()
			return false; // Returning empty. Just display the login error. It's not my problem (for now)
		}

		return true;
	}
}
