import { Button, Card, CardBody, Field } from '@helsingborg-stad/municipio-react-ui'
import { AssignmentInput, SignUpTypes } from '../../../../volunteer-service/VolunteerServiceContext'
import PhraseContext from '../../../../phrase/PhraseContext'
import { useContext } from 'react'
import useForm from '../../../../util/UseForm'

interface AssignmentFormProps {
  onSubmit: (input: AssignmentInput) => any
}

function AssignmentForm({ onSubmit }: AssignmentFormProps): JSX.Element {
  const { phrase } = useContext(PhraseContext)

  const { formState, handleInputChange, resetForm } = useForm<AssignmentInput>({
    initialState: {
      title: '',
      description: '',
      organisation: {
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
        type: SignUpTypes.Website,
        website: '',
        phone: '',
        email: '',
      },
    },
  })
  const {
    title,
    description,
    benefits,
    organisation,
    signUp,
    qualifications,
    schedule,
    location,
    totalSpots,
  } = formState

  return (
    <Card>
      <CardBody>
        <form>
          <div className="o-grid o-grid--form">
            <div className="o-grid-12">
              <Field
                value={formState.title}
                label={phrase('title', 'Title')}
                name="assignment-title"
                type="text"
                onChange={handleInputChange('title')}
              />
            </div>
            <div className="o-grid-12">
              <Field
                value={formState.description}
                label={phrase('description', 'Description')}
                name="assignment-description"
                type="text"
                onChange={handleInputChange('description')}
              />
            </div>
            <div className="o-grid-12">
              <Field
                value={formState.organisation.name}
                label={phrase('organisation_name', 'Organisation Name')}
                name="organisation-name"
                type="text"
                onChange={handleInputChange('organisation.name')}
              />
            </div>
            <div className="o-grid-12">
              <Field
                value={formState.organisation.website}
                label={phrase('organisation_website', 'Organisation Website')}
                name="organisation-website"
                type="text"
                onChange={handleInputChange('organisation.website')}
              />
            </div>
            <div className="o-grid-12">
              <Field
                value={formState.organisation.contacts[0].name}
                label={phrase('contact_name', 'Contact Name')}
                name="contact-name"
                type="text"
                onChange={handleInputChange('organisation.contacts.0.name')}
              />
            </div>
            <div className="o-grid-12">
              <Field
                value={formState.organisation.contacts[0].email}
                label={phrase('contact_email', 'Contact Email')}
                name="contact-email"
                type="email"
                onChange={handleInputChange('organisation.contacts.0.email')}
              />
            </div>
            <div className="o-grid-12">
              <Button
                onClick={() =>
                  onSubmit({
                    title,
                    description,
                    organisation,
                    signUp,
                    qualifications,
                    schedule,
                    benefits,
                    totalSpots,
                    location,
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
