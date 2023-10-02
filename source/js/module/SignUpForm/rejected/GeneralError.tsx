import SignUpForm from '../SignUpForm'
import Stack from '../../../components/stack/Stack'
import { Button } from '@helsingborg-stad/municipio-react-ui'

export const GeneralError = (props: {
  onClickClose: () => any
  buttonLabel: any
  noticeText: any
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
    onSubmit={() => {}}>
    <Stack spacing={3}>
      <Button
        className={'c-button__full-width'}
        disabled
        color={'secondary'}
        onClick={props.onClickClose}>
        {props.buttonLabel}
      </Button>
      <div className={'c-notice c-notice--danger'}>
        <span className="c-notice__message">{props.noticeText}</span>
      </div>
    </Stack>
  </SignUpForm>
)
