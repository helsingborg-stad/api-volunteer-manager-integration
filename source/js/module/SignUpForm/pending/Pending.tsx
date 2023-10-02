import { Volunteer } from '../../../volunteer-service/VolunteerServiceContext'
import SignUpForm from '../SignUpForm'
import Stack from '../../../components/stack/Stack'
import { Button } from '@helsingborg-stad/municipio-react-ui'

export const Pending = (props: {
  volunteer?: Volunteer
  disabledButtonLabel: any
  onClickClose: () => any
  logoutButtonLabel: any
}) => (
  <SignUpForm
    volunteer={{
      ...{
        firstName: '',
        lastName: '',
        id: '',
        email: '',
        phone: '',
        status: '',
      },
      ...(props.volunteer ?? {}),
    }}
    onSubmit={() => {}}>
    <Stack spacing={3}>
      <Button className={'c-button__full-width'} disabled color={'primary'}>
        {props.disabledButtonLabel}
      </Button>
      <Button
        className={'c-button__full-width'}
        disabled
        color={'secondary'}
        onClick={props.onClickClose}>
        {props.logoutButtonLabel}
      </Button>
    </Stack>
  </SignUpForm>
)
