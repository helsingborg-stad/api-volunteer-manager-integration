import { Button, Card, CardBody, Icon } from '@helsingborg-stad/municipio-react-ui'
import { AssignmentInput } from '../../volunteer-service/VolunteerServiceContext'
import PhraseContext from '../../phrase/PhraseContextInterface'
import { useCallback, useContext, useRef } from 'react'
import GeneralFields from './field-groups/GeneralFields'
import DetailsFields from './field-groups/DetailsFields'
import PublicContactFields from './field-groups/PublicContactFields'
import SignUpFields from './field-groups/SignUpFields'
import { CircularProgress } from '@mui/material'
import EmployerFields from './field-groups/EmployerFields'
import Grid from '../../components/grid/Grid'

interface AssignmentFormProps {
  formState: AssignmentInput
  handleChange: (field: string) => any
  onSubmit: (input: AssignmentInput) => any
  initialFormState?: AssignmentInput | null
  isLoading?: boolean
  errorMessage?: string
  isSubmitted?: boolean
}

function AssignmentForm({
  onSubmit,
  handleChange,
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
        <GeneralFields {...{ formState, handleChange, isLoading, isSubmitted }} />
        <DetailsFields {...{ formState, handleChange, isLoading, isSubmitted }} />
        <SignUpFields {...{ formState, handleChange, isLoading, isSubmitted }} />
        <PublicContactFields {...{ formState, handleChange, isLoading, isSubmitted }} />
        <EmployerFields {...{ formState, handleChange, isLoading, isSubmitted }} />
      </>
    ),
    [formState, isLoading, isSubmitted, handleChange],
  )

  return (
    <Card className="c-card--panel c-card--secondary">
      <CardBody
        style={{ margin: 'auto', maxWidth: '720px' }}
        className="u-padding--3 u-padding__y--8 u-padding--4@sm u-padding--4@md u-padding--5@lg u-padding--5@xl">
        <form ref={formRef} onSubmit={(e) => e.preventDefault()}>
          <Grid container>
            <Grid col={12}>
              {isSubmitted || isLoading ? (
                <div style={{ opacity: isSubmitted ? 0.8 : 0.5, userSelect: 'none' }}>
                  {renderFields()}
                </div>
              ) : (
                <>{renderFields()}</>
              )}
            </Grid>

            {!isSubmitted && phrase('form_terms', '').length > 0 ? (
              <Grid col={12} className="u-margin__top--2">
                <div dangerouslySetInnerHTML={{ __html: phrase('form_terms', '') }}></div>
              </Grid>
            ) : null}

            <Grid col={12} className="u-margin__top--2">
              {!isSubmitted ? (
                <Button
                  color="primary"
                  disabled={isLoading ?? false}
                  onClick={() =>
                    formRef.current?.reportValidity() &&
                    onSubmit({
                      ...formState,
                    })
                  }>
                  {!isLoading
                    ? phrase('submit_button_text', 'Submit')
                    : phrase('saving_text', 'Saving...')}
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
                      {phrase('success_text', 'Successfully submitted new assignment!')}
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
            </Grid>
          </Grid>
        </form>
      </CardBody>
    </Card>
  )
}

export default AssignmentForm
