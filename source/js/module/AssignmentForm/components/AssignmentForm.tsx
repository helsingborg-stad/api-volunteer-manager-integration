import { Button, Card, CardBody } from '@helsingborg-stad/municipio-react-ui'
import { AssignmentInput } from '../../../volunteer-service/VolunteerServiceContext'
import PhraseContext from '../../../phrase/PhraseContextInterface'
import { useContext } from 'react'
import useForm from '../../../hooks/UseForm'
import GeneralFields from './fields/GeneralFields'
import DetailsFields from './fields/DetailsFields'
import PublicContactFields from './fields/PublicContactFields'
import SignUpFields from './fields/SignUpFields'

interface AssignmentFormProps {
  onSubmit: (input: AssignmentInput) => any
}

function AssignmentForm({ onSubmit }: AssignmentFormProps): JSX.Element {
  const { phrase } = useContext(PhraseContext)

  const { formState, handleInputChange } = useForm<AssignmentInput>({
    initialState: {
      title: '',
      description: '',
      employer: {
        name: '',
        website: '',
        contacts: [
          {
            name: '',
            email: '',
          },
        ],
      },
      signUp: {
        type: undefined,
        link: '',
        phone: '',
        email: '',
        deadline: undefined,
        hasDeadline: '',
      },
      location: {
        address: '',
        postal: '',
        city: '',
      },
    },
  })

  return (
    <Card className="c-card--panel c-card--secondary">
      <CardBody className="u-padding--5">
        <form>
          <div className="o-grid">
            <div className="o-grid-12">
              <GeneralFields {...{ formState, handleInputChange }} />
              <DetailsFields {...{ formState, handleInputChange }} />
              <SignUpFields {...{ formState, handleInputChange }} />
              <PublicContactFields {...{ formState, handleInputChange }} />
            </div>
            <div className="o-grid-12 u-margin__top--2">
              <Button
                color="primary"
                onClick={() =>
                  onSubmit({
                    ...formState,
                  })
                }>
                {phrase('submit', 'Submit')}
              </Button>
            </div>
          </div>
        </form>
      </CardBody>
    </Card>
  )
}

export default AssignmentForm
