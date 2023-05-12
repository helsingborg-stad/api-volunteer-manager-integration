export type GetAccessTokenResponse = {
  token: string
  expires: number
  decoded: Record<string, string>
}

export type GetAccessToken = () => Promise<GetAccessTokenResponse>

export interface GdiHostInterface {
  getAccessToken: GetAccessToken
}
