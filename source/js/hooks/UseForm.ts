import { ChangeEvent, useCallback, useState } from 'react'
import { setNestedObjectValue } from '../util/setNestedObjectValue'

interface FormProps<T> {
  initialState: T
  resetState?: T
}

export function useForm<T>({ initialState, resetState }: FormProps<T>) {
  const [formState, setFormState] = useState<T>(initialState)

  const handleInputChange = useCallback(
    (field: string) =>
      (event: ChangeEvent<HTMLInputElement | HTMLTextAreaElement | HTMLSelectElement>) => {
        setFormState((prev) => {
          const newFormState = { ...prev }

          if (
            event.target instanceof HTMLInputElement &&
            event.target.files &&
            event.target.files.length > 0
          ) {
            // Handle file inputs
            setNestedObjectValue(newFormState, field, event.target.files)
          } else {
            // Handle other inputs
            setNestedObjectValue(newFormState, field, event.target.value)
          }

          return newFormState as T
        })
      },
    [],
  )

  const resetForm = useCallback(() => {
    setFormState(resetState || initialState)
  }, [resetState, initialState])

  return { formState, handleInputChange, resetForm }
}

export default useForm
