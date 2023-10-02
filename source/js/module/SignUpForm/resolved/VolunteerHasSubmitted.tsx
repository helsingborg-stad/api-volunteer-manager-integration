import { Volunteer } from '../../../volunteer-service/VolunteerServiceContext'
import SignUpForm from '../SignUpForm'
import Stack from '../../../components/stack/Stack'
import { Button, Icon } from '@helsingborg-stad/municipio-react-ui'

export const VolunteerHasSubmitted = (props: {
  volunteer: Volunteer
  signUpButtonLabel: any
  onClick: () => any
  logoutButtonLabel: any
  noticeText: any
}) => (
  <SignUpForm volunteer={props.volunteer}>
    <Stack spacing={3}>
      <Button className={'c-button__full-width'} disabled color={'primary'}>
        {props.signUpButtonLabel}
      </Button>
      <Button className={'c-button__full-width'} color={'secondary'} onClick={props.onClick}>
        {props.logoutButtonLabel}
      </Button>

      <div className={'c-notice c-notice--success'}>
        <span className="c-notice__icon">
          <Icon name={'check'} />
        </span>
        <span className="c-notice__message">{props.noticeText}</span>
      </div>
    </Stack>
  </SignUpForm>
)
