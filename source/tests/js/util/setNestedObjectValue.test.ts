import { setNestedObjectValue } from '../../../js/util/setNestedObjectValue'

describe('setNestedObjectValue', () => {
  test('should update the value of a nested key', () => {
    const obj = { a: { b: { c: 1 } } }
    const path = 'a.b.c'
    const value = 2
    const expected = { a: { b: { c: 2 } } }
    expect(setNestedObjectValue(obj, path, value)).toEqual(expected)
  })

  test('should create new nested keys and set a value for the last key', () => {
    const obj = { a: { b: { c: 1 } } }
    const path = 'a.b.d.e.f'
    const value = 2
    const expected = { a: { b: { c: 1, d: { e: { f: 2 } } } } }
    expect(setNestedObjectValue(obj, path, value)).toEqual(expected)
  })

  test('should create new nested keys and set a value for the last key when object is empty', () => {
    const obj = {}
    const path = 'a.b.c'
    const value = 2
    const expected = { a: { b: { c: 2 } } }
    expect(setNestedObjectValue(obj, path, value)).toEqual(expected)
  })

  test('should replace the value of a nested key with a new object', () => {
    const obj = { a: { b: { c: 1 } } }
    const path = 'a.b'
    const value = { d: 2 }
    const expected = { a: { b: { d: 2 } } }
    expect(setNestedObjectValue(obj, path, value)).toEqual(expected)
  })

  test('should not perform any operation when the path is empty', () => {
    const obj = {}
    const path = ''
    const value = 1
    const expected = {}
    expect(setNestedObjectValue(obj, path, value)).toEqual(expected)
  })
})
