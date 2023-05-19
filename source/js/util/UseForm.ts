import { ChangeEvent, useState } from 'react'

function setNestedObjectValue<T>(obj: T, path: string, value: any): T {
  const keys = path.split('.')
  let current: any = obj

  for (let i = 0; i < keys.length - 1; i++) {
    current = current[keys[i]]
  }

  current[keys[keys.length - 1]] = value
  return obj
}

interface FormProps<T> {
  initialState: T
  resetState?: T
}

export function useForm<T>({ initialState, resetState }: FormProps<T>) {
  const [formState, setFormState] = useState<T>(initialState)

  const handleInputChange = (field: string) => (event: ChangeEvent<{ value: unknown }>) => {
    setFormState((prev) => {
      const newFormState = { ...prev }
      setNestedObjectValue(newFormState, field, event.target.value as keyof typeof prev)
      return newFormState
    })
  }

  const resetForm = () => {
    setFormState(resetState || initialState)
  }

  return { formState, handleInputChange, resetForm }
}

export default useForm
