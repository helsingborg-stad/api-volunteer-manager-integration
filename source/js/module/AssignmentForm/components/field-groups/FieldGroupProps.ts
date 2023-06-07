import { AssignmentInput } from '../../../../volunteer-service/VolunteerServiceContext'

export interface FieldGroupProps {
  formState: AssignmentInput
  handleInputChange: (field: string) => any
  isLoading?: boolean
  isSubmitted?: boolean
}
