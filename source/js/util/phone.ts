import { CountryCode, parsePhoneNumber } from 'libphonenumber-js'

export const maybeNormalizePhoneNumber = (
  v: string,
  changeHandler: (formattedNumber: string) => void,
) => {
  try {
    const withPlus = v.startsWith('+')
    const withDoubleZero = v.startsWith('00')
    const withZero = !withDoubleZero && v.startsWith('0')
    const number = parsePhoneNumber(v, withPlus ? undefined : 'SE')
    if (
      (withZero && !number.formatNational().startsWith('0')) ||
      (withPlus && !number.isValid()) ||
      (withDoubleZero && !number.isValid()) ||
      (!withZero && !withPlus && !withDoubleZero && !number.isValid())
    )
      throw new Error('Skip format')

    return changeHandler(
      number.format(number.country === ('SE' as CountryCode) ? 'NATIONAL' : 'INTERNATIONAL', {
        nationalPrefix: true,
      }),
    )
  } catch (e) {
    return changeHandler(v)
  }
}
