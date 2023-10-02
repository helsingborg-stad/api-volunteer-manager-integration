import SignUpForm from '../SignUpForm'
import Stack from '../../../components/stack/Stack'
import { Button, Icon } from '@helsingborg-stad/municipio-react-ui'

export const VolunteerDoesNotExist = (props: {
  onSubmit: () => void
  onClick: () => any
  logoutButtonLabel: any
  noticeText: any
  registrationUrl: string
  registerButtonLabel: string
}) => (
  <SignUpForm
    volunteer={{
      ...{
        firstName: '-',
        lastName: '',
        id: '',
        email: '',
        phone: '',
        status: '',
      },
    }}
    onSubmit={props.onSubmit}>
    <Stack spacing={3}>
      <Button className={'c-button__full-width'} color={'secondary'} onClick={props.onClick}>
        {props.logoutButtonLabel}
      </Button>
      <Button
        color={'primary'}
        className={'c-button__full-width'}
        variant={'filled'}
        as={'a'}
        href={props.registrationUrl}>
        {props.registerButtonLabel}
      </Button>
      <div className={'c-notice c-notice--danger'}>
        <span className={'c-notice__icon'}>
          <Icon name={'no_accounts'} />
        </span>
        <span className="c-notice__message">{props.noticeText}</span>
      </div>
    </Stack>
  </SignUpForm>
)
