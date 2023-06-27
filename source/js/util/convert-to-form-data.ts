type ValueHandler = (key: string, value: any) => [string, string | Blob][]

const handlers: Record<string, ValueHandler> = {
  FileList: (key, value: FileList) => Array.from(value).map((file, i) => [`${key}[${i}]`, file]),
  File: (key, value: File) => [[key, value]],
  Blob: (key, value: Blob) => [[key, value]],
  Array: (key, value: any[]) =>
    value.flatMap((v, i) =>
      (handlers[v?.constructor?.name] || handlers.default)(`${key}[${i}]`, v),
    ),
  Object: (key, value: object) =>
    Object.entries(value).flatMap(([subKey, subValue]) =>
      (handlers[subValue?.constructor?.name] || handlers.default)(`${key}[${subKey}]`, subValue),
    ),
  undefined: (key, value: undefined) => [],
  default: (key, value) => [[key, value.toString()]],
}

export const convertToFormData = (object: { [key: string]: any }): FormData =>
  Object.entries(object)
    .flatMap(([key, value]) => (handlers[value?.constructor?.name] || handlers.default)(key, value))
    .reduce((formData, [key, value]) => (formData.append(key, value), formData), new FormData())
