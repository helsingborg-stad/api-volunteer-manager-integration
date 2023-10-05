export type EventFnType = (
  e: React.ChangeEvent<HTMLInputElement | HTMLSelectElement | HTMLTextAreaElement>,
) => any

export const composeEventFns =
  (fns: EventFnType[]) =>
  (e: React.ChangeEvent<HTMLInputElement | HTMLSelectElement | HTMLTextAreaElement>) =>
    fns.map((fn) => fn(e))

export const parseValue =
  (cb: (v: any) => any) =>
  (e: React.ChangeEvent<HTMLInputElement | HTMLSelectElement | HTMLTextAreaElement>) =>
    cb(e.target.value)

export type ValidationCallbackType = (v: any, state: ValidityState) => string
export const setValidity =
  (cb: ValidationCallbackType) =>
  (e: React.ChangeEvent<HTMLInputElement | HTMLSelectElement | HTMLTextAreaElement>) =>
    e.target.setCustomValidity(cb(e.target.value, e.target.validity) ?? '')

export const reportValidity = (
  e: React.ChangeEvent<HTMLInputElement | HTMLSelectElement | HTMLTextAreaElement>,
) => e.target.value && e.target.reportValidity()
