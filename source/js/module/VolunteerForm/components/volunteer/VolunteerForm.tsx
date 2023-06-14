import { Button, Card, CardBody, Field, Icon } from '@helsingborg-stad/municipio-react-ui'
import { Volunteer } from '../../../../volunteer-service/VolunteerServiceContext'
import PhraseContext from '../../../../phrase/PhraseContextInterface'
import { useContext, useRef } from 'react'
import FormSection from '../../../../components/form/FormSection'
import { CircularProgress } from '@mui/material'

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
    <Card>
      <CardBody
        style={{ margin: 'auto', maxWidth: '720px' }}
        className="u-padding--3 u-padding__y--8 u-padding--4@sm u-padding--4@md u-padding--5@lg u-padding--5@xl">
        <form ref={formRef} onSubmit={(e) => e.preventDefault()}>
          <FormSection sectionTitle={phrase('register_volunteer_title', 'Register as a volunteer')}>
            <div className="o-grid-12">
              <Field
                value={`${firstName} ${lastName}`}
                label={phrase('name', 'Name')}
                name="volunteer-name"
                type="text"
                readOnly
                onChange={function noRefCheck() {}}
              />
            </div>
            <div className="o-grid-12">
              <Field
                value={id}
                label={phrase('personal_number', 'Personal Identity number')}
                name="volunteer-id"
                type="text"
                readOnly
                onChange={function noRefCheck() {}}
              />
            </div>
          </FormSection>
          <FormSection
            sectionTitle={phrase('contact_details_title', 'Contact information')}
            isSubSection={true}>
            <div className="o-grid-12">
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
            </div>
            <div className="o-grid-12">
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
            </div>
          </FormSection>
          <div className="o-grid form-section">
            <div className="o-grid-12">
              {!isSubmitted ? (
                <Button
                  disabled={(isLoading || isSubmitted) ?? false}
                  onClick={() => formRef.current?.reportValidity() && onSubmit(volunteer)}>
                  {!isLoading ? phrase('submit', 'Submit') : phrase('submitting', 'Submitting..')}
                </Button>
              ) : null}
              {message && message.length > 0 ? (
                <div>
                  <div
                    className={
                      hasError ? 'c-notice  c-notice--danger' : 'c-notice  c-notice--success'
                    }>
                    <span className="c-notice__icon">
                      <Icon name={hasError ? 'report' : 'check'} />
                    </span>
                    <span className="c-notice__message">{message}</span>
                  </div>
                </div>
              ) : null}
              {isLoading ? (
                <div
                  className={'u-display--inline-block u-margin__left--2 u-color__text--secondary'}>
                  <CircularProgress color="inherit" style={{ marginBottom: '-16px' }} />
                </div>
              ) : null}
            </div>
          </div>
        </form>
      </CardBody>
    </Card>
  )
}

export default VolunteerForm
