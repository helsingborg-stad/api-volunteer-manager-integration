import { AssignmentInput } from '../../../volunteer-service/VolunteerServiceContext'

export interface FieldGroupProps {
  formState: AssignmentInput
  handleChange: (field: string) => (value: any) => any
  isLoading?: boolean
  isSubmitted?: boolean
}
