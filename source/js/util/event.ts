export const parseValue =
  (cb: (v: any) => any) =>
  (e: React.ChangeEvent<HTMLInputElement | HTMLSelectElement | HTMLTextAreaElement>) =>
    cb(e.target.value)
