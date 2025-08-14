export class OfficialAuthError extends Error {
	constructor(operation: string, statusCode: number | null) {
		super(`Official auth error in operation '${operation}'.` + statusCode? " Status code: " + statusCode.toString() : "");
		this.name = 'OfficialAuthError';

		Object.setPrototypeOf(this, OfficialAuthError.prototype);

	}

}

// Todo: rewrite to using dictionary or mappings instead of arrays, as that is faster. And I like speed.
// Holy shit nerdy ass CS moment.
export const TokenManager = new class {
	/**
	 * Takes the document cookie, splits it on `; `, then maps each key:values pair.
	 * @private
	 * @pre document.cookie consists of n >= 0 key=values pairs, separated by `; `.
	 * @post an array of [key, value] pairs, which require a call on decodeURIComponent on value to be fully usable.
	 */
	private getCookie(): string[][] {
		console.assert(document.cookie !== undefined);
		console.assert(document.cookie !== null);
		return document.cookie.split('; ').map(part => part.split('='));
	}

	/**
	 * Sets the cookie to a string comprehension of the passed-in array of [key, value] pairs.
	 * @param cookie array of [key, value] pairs.
	 * @private
	 */
	private setCookie(cookie: string[][]) {
		let out = ""
		cookie.forEach(([key, value]) => {
			out += `${key}=${value}; `;
		});
		if (out.endsWith(" ")) { out = out.slice(0, -1); } // Remove last space if cookie is not empty.
		document.cookie = out;
	}

	/**
	 * Finds the value of a given key inside the cookie. Returns undefined if not found.
	 * @param entry The key to look for.
	 * @private
	 */
	private findEntry(entry: string): string | undefined {
		const pair = this.getCookie().find(([k]) => k === entry); //typeof [key, value]
		if (!pair) return undefined;
		return decodeURIComponent(pair[1]);
	}

	/**
	 * Sets the value of the given key inside the cookie. Overwrites if it exists.
	 * @param key The key to set the value of.
	 * @param value The value to be set to the given key. Overwrites existing value if key already exists.
	 * @private
	 */
	private setEntry(key: string, value: string): void {
		let cookie = this.getCookie();
		const index = cookie.findIndex(([k]) => k === key);
		if (index >= 0) {
			cookie[index][1] = encodeURIComponent(value);
		} else {
			cookie.push([key, encodeURIComponent(value)]);
		}
		this.setCookie(cookie);
	}

	/**
	 * Removes given entries from cookies entirely.
	 * @param keys Any key=value pair will be excluded if it's in this collection.
	 * @private
	 */
	private removeEntries(keys: string | string[]): void {
		const keysToRemove = Array.isArray(keys) ? keys : [keys];
		let cookie = this.getCookie().filter(([k]) => !keysToRemove.includes(k));
		this.setCookie(cookie);
	}

	getToken(): string | undefined {
		const val = this.findEntry("ps-token");
		if (!val) return undefined;
		return val;
	}

	setToken(token: string) {
		this.setEntry("ps-token", token);
	}

	getTokenExpiry(): number | undefined {
		const val = this.findEntry("ps-token-expiry")
		if (!val) return undefined;
		return Number(val);
	}

	setTokenExpiry(expiry: number) {
		this.setEntry("ps-token-expiry", String(expiry));
	}
}


/**
 * Quick and dirty interface draft; methods to place requests are located here.
 * Please check pre and post conditions.
 */
export const OfficialAuth = new class {
	private apiUrl = "play.pokemon" + "showdown.com/api/oauth/";  // As per usual, hacky workaround for Cachebuster because I'm too lazy to update it.
	private clientId = ""; // Todo: fill in once received.

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

	async refreshToken() {
		const token = TokenManager.getToken();
		console.assert(token !== undefined);
		if (!token) {
			return;
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

		if (data.success) {
			return {
				newToken: data.success,
				expires: data.expires
			};
		} else {
			throw new OfficialAuthError(`refreshToken`, data.status);
		}
	}
}
