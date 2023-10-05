export const urlPattern = new RegExp(
  Object.values({
    protocol: '^(https?:\\/\\/)?',
    www: '(www\\.)?',
    domainName: '([a-zA-Z0-9][a-zA-Z0-9-]{1,61}[a-zA-Z0-9]\\.)+',
    tld: '[a-zA-Z]{2,}',
    path: '(\\/[\\w\\-\\.]+)*',
    filePath: '(\\/[\\w\\-]+(\\.[a-zA-Z]{2,})?)?\\/?',
    queryString: "(\\?([\\w\\-.~%!$&'()*+,;=:@]+(=[\\w\\-.~%!$&'()*+,;=:@]*)?)*)?",
    fragment: '(#[\\w\\-]*)?$',
  }).join(''),
)
export const isValidUrl = (url: string) => urlPattern.test(url)
export const normalizeUrlProtocol = (url: string): string =>
  !url ? '' : url.startsWith('http://') || url.startsWith('https://') ? url : `https://${url}`
export const normalizeUrl = (url: string): string => normalizeUrlProtocol(url)
export const tryNormalizeUrl = (changeHandler: (url: string) => void, currentUrl?: string | null) =>
  currentUrl &&
  currentUrl.length > 0 &&
  normalizeUrl(currentUrl) !== currentUrl &&
  isValidUrl(normalizeUrl(currentUrl)) &&
  changeHandler(normalizeUrl(currentUrl))
