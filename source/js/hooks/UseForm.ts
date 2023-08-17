import { ChangeEvent, useCallback, useState } from 'react'
import { setObjectProperty } from '../util/set-object-property'

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
            setObjectProperty(newFormState, field, event.target.files)
          } else {
            // Handle other inputs
            setObjectProperty(newFormState, field, event.target.value)
          }

          return newFormState as T
        })
      },
    [],
  )

  const handleChange = useCallback(
    (field: string) => (value: any) => {
      setFormState((prev) => setObjectProperty({ ...prev }, field, value) as T)
    },
    [],
  )

  const resetForm = useCallback(() => {
    setFormState(resetState || initialState)
  }, [resetState, initialState])

  return { formState, handleInputChange, handleChange, resetForm }
}

export default useForm
