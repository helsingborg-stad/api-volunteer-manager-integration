export const setObjectProperty = (obj: any, path: string, value: unknown): any => {
  path
    .split('.')
    .filter((k) => k.length > 0)
    .reduce((o: any, key: string, index: number, keys: string[]) => {
      if (index === keys.length - 1) o[key] = value
      else o[key] = o[key] || {}
      return o[key]
    }, obj)
  return obj
}
