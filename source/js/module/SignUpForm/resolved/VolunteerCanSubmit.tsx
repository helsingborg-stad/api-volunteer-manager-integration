import { Volunteer } from '../../../volunteer-service/VolunteerServiceContext'
import SignUpForm from '../SignUpForm'
import Stack from '../../../components/stack/Stack'
import { Button } from '@helsingborg-stad/municipio-react-ui'

export const VolunteerCanSubmit = (props: {
  volunteer: Volunteer
  onClickSubmit: () => void
  signUpButtonLabel: any
  onClickClose: () => any
  logoutButtonLabel: any
}) => (
  <SignUpForm volunteer={props.volunteer}>
    <Stack spacing={3}>
      <Button className={'c-button__full-width'} color={'primary'} onClick={props.onClickSubmit}>
        {props.signUpButtonLabel}
      </Button>
      <Button className={'c-button__full-width'} color={'secondary'} onClick={props.onClickClose}>
        {props.logoutButtonLabel}
      </Button>
    </Stack>
  </SignUpForm>
)
