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
	private apiUrl = "play.pokemonshowdown.com/api/oauth/";
	private clientId = ""; // Todo: fill in once received.
	private redirectURI = "";

	/**
	 * Returns a new URL object with the given api endpoint.
	 * @param endpoint The endpoint to reach, directly behind oauth.
	 * @pre endpoint is of type string with length >= 0, whose first character may not be /
	 * @post a new URL object containing the API url appended by the given endpoint.
	 */
	requestUrl(endpoint: string): URL {
		console.assert(endpoint.length >= 0);
		console.assert(!endpoint.startsWith("/"));
		return new URL(this.apiUrl + endpoint);
	}

	/**
	 * Refreshes the currently stored auth token in cookies.
	 * Returns false if no token was found, or it already expired.
	 * True if operation succeeded.
	 */
	async refreshToken(): Promise<boolean> {
		const token = CookieManager.getToken();
		if (!token) {
			return false;
		}
		const tokenExpiry = CookieManager.getTokenExpiry();
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

		CookieManager.setToken(data.success);

		console.assert(data.expires !== undefined);
		console.assert(typeof data.expires === "number");

		CookieManager.setTokenExpiry(data.expires!);
		return true;
	}

	authorize(challenge: string): void {
		const authorizeUrl = this.requestUrl("authorize");
		authorizeUrl.searchParams.append('redirect_uri', this.redirectURI);
		authorizeUrl.searchParams.append('client_id', this.clientId);
		authorizeUrl.searchParams.append('challenge', challenge);

		const popup = window.open(authorizeUrl, undefined, 'popup=1');
		const checkIfUpdated = () => {
			try {
				if (popup?.location?.href?.startsWith(this.redirectURI)) {
					const url = new URL(popup.location.href);
					const assertion = url.searchParams.get('assertion');
					if (!assertion) {
						console.error('Received no assertion');
						return;
					}

					runLoginWithAssertion(url.searchParams.get('assertion'));

					const token = url.searchParams.get('token');
					if (!token) {
						console.error('Received no token')
						return;
					}

					localStorage.setItem('ps-token', token);
					localStorage.
					popup.close();
				} else {
					setTimeout(checkIfUpdated, 500);
				}
			} catch (DOMException) {
				setTimeout(checkIfUpdated, 500);
			}
		};

		checkIfUpdated();
	}
}
