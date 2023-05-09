export type AccessTokenResponse = {
  token: string
  expires: number
}

export type GetAccessToken = () => Promise<AccessTokenResponse>

export interface GdiHostInterface {
  getAccessToken: GetAccessToken
}
