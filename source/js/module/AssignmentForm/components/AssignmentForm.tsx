import { Button, Card, CardBody, Icon } from '@helsingborg-stad/municipio-react-ui'
import { AssignmentInput } from '../../../volunteer-service/VolunteerServiceContext'
import PhraseContext from '../../../phrase/PhraseContextInterface'
import { useCallback, useContext, useRef } from 'react'
import GeneralFields from './field-groups/GeneralFields'
import DetailsFields from './field-groups/DetailsFields'
import PublicContactFields from './field-groups/PublicContactFields'
import SignUpFields from './field-groups/SignUpFields'
import { CircularProgress } from '@mui/material'

interface AssignmentFormProps {
  formState: AssignmentInput
  handleInputChange: (
    field: string,
  ) => (
    event: React.ChangeEvent<HTMLInputElement | HTMLSelectElement | HTMLTextAreaElement>,
  ) => void
  onSubmit: (input: AssignmentInput) => any
  initialFormState?: AssignmentInput | null
  isLoading?: boolean
  errorMessage?: string
  isSubmitted?: boolean
}

function AssignmentForm({
  onSubmit,
  handleInputChange,
  formState,
  isLoading,
  errorMessage,
  isSubmitted,
}: AssignmentFormProps): JSX.Element {
  const { phrase } = useContext(PhraseContext)
  const formRef = useRef<HTMLFormElement>(null)

  const renderFields = useCallback(
    () => (
      <>
        <GeneralFields {...{ formState, handleInputChange, isLoading, isSubmitted }} />
        <DetailsFields {...{ formState, handleInputChange, isLoading, isSubmitted }} />
        <SignUpFields {...{ formState, handleInputChange, isLoading, isSubmitted }} />
        <PublicContactFields {...{ formState, handleInputChange, isLoading, isSubmitted }} />
      </>
    ),
    [formState, isLoading, isSubmitted, handleInputChange],
  )

  return (
    <Card className="c-card--panel c-card--secondary">
      <CardBody
        style={{ margin: 'auto', maxWidth: '720px' }}
        className="u-padding--3 u-padding__y--8 u-padding--4@sm u-padding--4@md u-padding--5@lg u-padding--5@xl">
        <form ref={formRef} onSubmit={(e) => e.preventDefault()}>
          <div className="o-grid">
            <div className="o-grid-12">
              {isSubmitted || isLoading ? (
                <div
                  //className={'u-padding--3 u-border--1 '}
                  style={{ opacity: isSubmitted ? 1 : 0.5, userSelect: 'none' }}>
                  {renderFields()}
                </div>
              ) : (
                <>{renderFields()}</>
              )}
            </div>
            <div className="o-grid-12 u-margin__top--2">
              {!isSubmitted ? (
                <Button
                  color="primary"
                  disabled={isLoading ?? false}
                  onClick={async () => {
                    formRef.current?.reportValidity() &&
                      onSubmit({
                        ...formState,
                      })
                  }}>
                  {!isLoading ? phrase('submit', 'Submit') : phrase('uploading', 'Uploading..')}
                </Button>
              ) : null}

              {errorMessage && errorMessage.length > 0 ? (
                <div className={'u-margin__top--4'}>
                  <div className={'c-notice c-notice--danger'}>
                    <span className="c-notice__icon">
                      <Icon name={'check'} />
                    </span>
                    <span className="c-notice__message">{errorMessage}</span>
                  </div>
                </div>
              ) : null}
              {isSubmitted ? (
                <div className={'u-margin__top--4'}>
                  <div className={'c-notice c-notice--success'}>
                    <span className="c-notice__icon">
                      <Icon name={'check'} />
                    </span>
                    <span className="c-notice__message">
                      {'Successfully submitted new assignment!'}
                    </span>
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

export default AssignmentForm
