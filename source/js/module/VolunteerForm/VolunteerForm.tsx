import { Button, Field, Icon, Select } from '@helsingborg-stad/municipio-react-ui'
import { Volunteer } from '../../volunteer-service/VolunteerServiceContext'
import PhraseContext from '../../phrase/PhraseContextInterface'
import { useContext, useRef } from 'react'
import { CircularProgress } from '@mui/material'
import Stack from '../../components/stack/Stack'
import { composeEventFns, parseValue, reportValidity, setValidity } from '../../util/event'
import { tryFormatPhoneNumber, validatePhoneNumber } from '../../util/phone'

interface VolunteerFormProps {
  volunteer: Volunteer
  onSubmit: (input: Volunteer) => any
  isLoading?: boolean
  isSubmitted?: boolean
  hasError?: boolean
  message?: string
  handleChange: (field: string) => (value: any) => void
}

function VolunteerForm({
  volunteer,
  onSubmit,
  isLoading,
  isSubmitted,
  hasError,
  message,
  handleChange,
}: VolunteerFormProps): JSX.Element {
  const { firstName, lastName } = volunteer || { firstName: '', lastName: '', id: '' }
  const { phrase } = useContext(PhraseContext)
  const formRef = useRef<HTMLFormElement>(null)

  return (
    <form ref={formRef} onSubmit={(e) => e.preventDefault()}>
      <Stack spacing={4}>
        <Field
          value={`${firstName} ${lastName}`}
          label={phrase('field_label_volunteer_name', 'Name')}
          name="volunteer_name"
          type="text"
          onChange={function noRefCheck() {}}
          inputProps={{ disabled: true }}
          readOnly={isSubmitted ?? false}
        />
        <Field
          value={volunteer?.email ?? ''}
          label={phrase('field_label_volunteer_email', 'E-mail address')}
          name="volunteer_email"
          type="email"
          required
          onChange={parseValue(handleChange('email'))}
          inputProps={isLoading || isSubmitted ? { disabled: true } : {}}
          readOnly={isSubmitted ?? false}
        />
        <Field
          value={volunteer?.phone ?? ''}
          label={phrase('field_label_volunteer_phone', 'Phone number')}
          name="volunteer_phone"
          type="phone"
          required
          onChange={composeEventFns([
            setValidity(validatePhoneNumber),
            parseValue(tryFormatPhoneNumber(handleChange('phone'))),
          ])}
          onBlur={reportValidity}
          inputProps={isLoading || isSubmitted ? { disabled: true } : {}}
          readOnly={isSubmitted ?? false}
        />
        <Select
          options={[
            [
              true.toString(),
              phrase(
                'field_option_label_volunteer_newsletter_true',
                'Yes i want to receive the newsletter',
              ),
            ],
            [
              false.toString(),
              phrase(
                'field_option_label_volunteer_newsletter_false',
                'No i do not want to receive the newsletter',
              ),
            ],
          ]}
          value={(volunteer?.newsletter ?? '').toString()}
          label={phrase('field_label_volunteer_newsletter', 'Newsletter')}
          name="volunteer_newsletter"
          onChange={parseValue((v) => {
            handleChange('newsletter')(String(v).toLowerCase() === 'true')
          })}
          onBlur={reportValidity}
          required
          placeholder={phrase('select_placeholder', 'Select an option')}
          selectProps={isLoading || isSubmitted ? { disabled: true } : {}}
          readOnly={isSubmitted}
        />

        {!isSubmitted && phrase('form_terms', '').length > 0 ? (
          <div dangerouslySetInnerHTML={{ __html: phrase('form_terms', '') }}></div>
        ) : null}
        {!isSubmitted ? (
          <Button
            variant="filled"
            color="primary"
            disabled={(isLoading || isSubmitted) ?? false}
            onClick={() => formRef.current?.reportValidity() && onSubmit(volunteer)}>
            {!isLoading ? phrase('submit', 'Submit') : phrase('submitting', 'Submitting..')}
          </Button>
        ) : null}
        {message && message.length > 0 ? (
          <div>
            <div
              className={hasError ? 'c-notice  c-notice--danger' : 'c-notice  c-notice--success'}>
              <span className="c-notice__icon">
                <Icon name={hasError ? 'report' : 'check'} />
              </span>
              <span className="c-notice__message">{message}</span>
            </div>
          </div>
        ) : null}
        {isLoading ? (
          <div className={'u-display--inline-block u-margin__left--2 u-color__text--secondary'}>
            <CircularProgress color="inherit" style={{ marginBottom: '-16px' }} />
          </div>
        ) : null}
      </Stack>
    </form>
  )
}

export default VolunteerForm
