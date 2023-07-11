import { Button, Field, Icon } from '@helsingborg-stad/municipio-react-ui'
import { Volunteer } from '../../../../volunteer-service/VolunteerServiceContext'
import PhraseContext from '../../../../phrase/PhraseContextInterface'
import { useContext, useRef } from 'react'
import { CircularProgress } from '@mui/material'
import Grid from '../../../../components/grid/Grid'

interface VolunteerFormProps {
  volunteer: Volunteer
  onSubmit: (input: Volunteer) => any
  isLoading?: boolean
  isSubmitted?: boolean
  hasError?: boolean
  message?: string
  handleInputChange: (
    field: string,
  ) => (
    event: React.ChangeEvent<HTMLInputElement | HTMLSelectElement | HTMLTextAreaElement>,
  ) => void
}

function VolunteerForm({
  volunteer,
  onSubmit,
  handleInputChange,
  isLoading,
  isSubmitted,
  hasError,
  message,
}: VolunteerFormProps): JSX.Element {
  const { firstName, lastName, id } = volunteer || { firstName: '', lastName: '', id: '' }
  const { phrase } = useContext(PhraseContext)
  const formRef = useRef<HTMLFormElement>(null)

  return (
    <form ref={formRef} onSubmit={(e) => e.preventDefault()}>
      <Grid className={'o-grid--form'} container>
        <Grid>
          <Field
            value={`${firstName} ${lastName}`}
            label={phrase('name', 'Name')}
            name="volunteer-name"
            type="text"
            onChange={function noRefCheck() {}}
            inputProps={{ disabled: true }}
            readOnly={isSubmitted ?? false}
          />
        </Grid>
        <Grid>
          <Field
            value={volunteer?.email ?? ''}
            label={phrase('email', 'E-mail address')}
            name="volunteer-email"
            type="email"
            required
            onChange={handleInputChange('email')}
            inputProps={isLoading || isSubmitted ? { disabled: true } : {}}
            readOnly={isSubmitted ?? false}
          />
        </Grid>
        <Grid>
          <Field
            value={volunteer?.phone ?? ''}
            label={phrase('phone', 'Phone number')}
            name="volunteer-phone"
            type="phone"
            required
            onChange={handleInputChange('phone')}
            inputProps={isLoading || isSubmitted ? { disabled: true } : {}}
            readOnly={isSubmitted ?? false}
          />
        </Grid>
      </Grid>

      <div className="o-grid form-section">
        <div className="o-grid-12">
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
        </div>
      </div>
    </form>
  )
}

export default VolunteerForm
