import { Volunteer } from '../../../volunteer-service/VolunteerServiceContext'
import SignUpForm from '../SignUpForm'
import Stack from '../../../components/stack/Stack'
import { Button, Icon } from '@helsingborg-stad/municipio-react-ui'

export const VolunteerNotVerified = (props: {
  volunteer: Volunteer
  signUpButtonLabel: any
  onClickClose: () => any
  logoutButtonLabel: any
  noticeText: any
}) => (
  <SignUpForm volunteer={props.volunteer}>
    <Stack spacing={3}>
      <Button className={'c-button__full-width'} disabled color={'primary'}>
        {props.signUpButtonLabel}
      </Button>
      <Button className={'c-button__full-width'} color={'secondary'} onClick={props.onClickClose}>
        {props.logoutButtonLabel}
      </Button>
      <div className={'c-notice c-notice--warning'}>
        <span className={'c-notice__icon'}>
          <Icon name={'pending_actions'} />
        </span>
        <span className="c-notice__message">{props.noticeText}</span>
      </div>
    </Stack>
  </SignUpForm>
)
