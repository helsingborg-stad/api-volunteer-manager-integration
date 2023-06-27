export type URLUpdateFn = (params: URLSearchParams) => URLSearchParams

export const nullUpdateFn = (params: URLSearchParams) => params

export const createAddQueryParamsFn =
  (queryParams: Record<string, string> = {}): URLUpdateFn =>
  (params: URLSearchParams): URLSearchParams => {
    Object.entries(queryParams).forEach(([key, value]) => {
      params.set(key, value)
    })
    return params
  }

export const createRemoveQueryParamsFn =
  (keyList: string[] = []): URLUpdateFn =>
  (params: URLSearchParams): URLSearchParams => {
    keyList.forEach((key) => {
      params.delete(key)
    })
    return params
  }

export const composeURLUpdateFns =
  (fns: URLUpdateFn[]): URLUpdateFn =>
  (params: URLSearchParams) =>
    fns.reduce((acc, fn) => fn(acc), params)

export const updateURLWith = (
  updates: {
    add?: Record<string, string>
    remove?: string[]
    fn?: URLUpdateFn | URLUpdateFn[]
  },
  shouldReload: boolean = false,
  historyMethod: 'pushState' | 'replaceState' = 'replaceState',
) => {
  const addFn = updates?.add ? createAddQueryParamsFn(updates.add) : nullUpdateFn
  const removeFn = updates?.remove ? createRemoveQueryParamsFn(updates.remove) : nullUpdateFn

  const updateFn = composeURLUpdateFns([
    addFn,
    removeFn,
    ...(updates?.fn ? ([] as URLUpdateFn[]).concat(updates.fn) : []),
  ])

  const url = new URL(window.location.href)
  const { searchParams } = url
  const newParams = updateFn(searchParams)
  const newUrl = `${url.origin}${url.pathname}?${newParams.toString()}`

  window.history[historyMethod]({}, '', newUrl)

  if (shouldReload) {
    window.location.reload()
  }
}
