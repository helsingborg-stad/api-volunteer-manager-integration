import {
  Button,
  Card,
  CardBody,
  CardHeader,
  Field,
  Select,
  Textarea,
  Typography,
} from '@helsingborg-stad/municipio-react-ui'
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

  const {
    title,
    description,
    benefits,
    employer,
    signUp,
    qualifications,
    schedule,
    location,
    totalSpots,
  } = formState

  const EmployerFields = (
    <>
      <div className="o-grid-12 o-grid-6@md">
        <Field
          value={formState.employer.name}
          label={phrase('field_label_organisation', 'Organisation')}
          name="organisation_name"
          type="text"
          onChange={handleInputChange('employer.name')}
          required
        />
      </div>
      <div className="o-grid-12 o-grid-6@md">
        <Field
          value={formState.employer.website}
          label={phrase('field_label_organisation_website', 'Website (optional)')}
          name="organisation_website"
          type="url"
          onChange={handleInputChange('employer.website')}
        />
      </div>
    </>
  )

  const ContactFields = (
    <>
      <div className="o-grid-12 u-margin__top--2">
        <Typography variant="h3">
          {phrase('contact_information', '2. Contact information')}
        </Typography>
      </div>
      <div className="o-grid-12 o-grid-4@md">
        <Field
          value={formState.employer.contacts[0].name}
          label={phrase('field_label_contact_name', 'Name')}
          name="contact_name"
          type="text"
          onChange={handleInputChange('employer.contacts.0.name')}
        />
      </div>
      <div className="o-grid-12 o-grid-4@md">
        <Field
          value={formState.employer.contacts[0].email}
          label={phrase('field_label_contact_email', 'E-mail')}
          name="contact_email"
          type="email"
          onChange={handleInputChange('employer.contacts.0.email')}
        />
      </div>
      <div className="o-grid-12 o-grid-4@md">
        <Field
          value={formState.employer.contacts[0].phone}
          label={phrase('field_label_contact_phone', 'Phone')}
          name="contact_phone"
          type="tel"
          onChange={handleInputChange('employer.contacts.0.phone')}
        />
      </div>
    </>
  )

  const signupLink =
    formState.signUp.type === SignUpTypes.Link ? (
      <div className="o-grid-12">
        <Field
          value={formState.signUp.link ?? ''}
          label={phrase('field_label_signup_link', 'signUp link')}
          name="signup_link"
          type="text"
          onChange={handleInputChange('signUp.link')}
        />
      </div>
    ) : null

  const signupPhone =
    formState.signUp.type === SignUpTypes.Phone ? (
      <div className="o-grid-12">
        <Field
          value={formState.signUp.phone}
          label={phrase('field_label_signup_phone', 'SignUp Phone')}
          name="signup_phone"
          type="text"
          onChange={handleInputChange('signUp.phone')}
        />
      </div>
    ) : null

  const signupEmail =
    formState.signUp.type === SignUpTypes.Email ? (
      <div className="o-grid-12">
        <Field
          value={formState.signUp.phone}
          label={phrase('field_label_signup_email', 'E-mail')}
          name="signup_email"
          type="text"
          onChange={handleInputChange('signUp.email')}
        />
      </div>
    ) : null

  const SignUpFields = (
    <>
      <div className="o-grid-12 u-margin__top--2">
        <Typography variant="h3">
          {phrase('field_group_label_signup', '3. Sign-up information')}
        </Typography>
      </div>
      <div className="o-grid-12">
        <Select
          options={[
            ['link', 'Sign up Link'],
            ['email', 'E-mail'],
            ['phone', 'Phone'],
          ]}
          value={formState.signUp.type ?? ''}
          label={phrase('field_label_signup_signup_type', 'SignUp Type')}
          name="signup_type"
          onChange={handleInputChange('signUp.type')}
          required
        />
      </div>

      {signupLink}
      {signupPhone}
      {signupEmail}

      <div className="o-grid-12">
        <Field
          value={formState.signUp?.deadline ?? ''}
          label={phrase('field_label_signup_due_date', 'Last date to apply (optional)')}
          name="signup_email"
          type="date"
          onChange={handleInputChange('signUp.deadline')}
          helperText={phrase('field_helper_signup_due_date', 'Leave empty to keep signup open')}
        />
      </div>
    </>
  )

  const LocationFields = (
    <>
      <div className="o-grid-12">
        <Textarea
          value={formState.location?.address}
          label={phrase('field_label_location_address', 'Address')}
          name="location_address"
          rows={1}
          onChange={handleInputChange('location.address')}
        />
      </div>
      <div className="o-grid-6">
        <Field
          value={formState.location?.postal}
          label={phrase('field_label_location_postal', 'Postal')}
          name="location_postal"
          type="text"
          onChange={handleInputChange('location.postal')}
        />
      </div>
      <div className="o-grid-6">
        <Field
          value={formState.location?.city}
          label={phrase('field_label_location_city', 'City')}
          name="location_city"
          type="text"
          onChange={handleInputChange('location.city')}
        />
      </div>
    </>
  )
  return (
    <Card className="c-card--panel c-card--secondary">
      <CardHeader>
        <Typography element="h2" variant="h4">
          {phrase('field_group_label_assignment_details', 'Submit Volunteer Assignment Form')}
        </Typography>
      </CardHeader>
      <CardBody>
        <form>
          <div className="o-grid o-grid--form">
            <div className="o-grid-12 u-margin__top--0">
              <Typography variant="h3">
                {phrase('field_group_label_assignment_details', '1. About the Assignment')}
              </Typography>
            </div>
            {/*            <div className="o-grid-12 u-margin__top--0">
              <Typography variant="h3">
                {phrase(
                  'field_group_label_assignment_details',
                  '1. Name your assignment and upload an image',
                )}
              </Typography>
            </div>*/}
            <div className="o-grid-12">
              <Field
                value={formState.title}
                label={phrase('field_label_title', 'Name of the assignment')}
                name="assignment_title"
                type="text"
                onChange={handleInputChange('title')}
                required
              />
            </div>
            <div className="o-grid-12">
              <Textarea
                value={formState.description}
                label={phrase('field_label_description', 'Description')}
                name="assignment_description"
                onChange={handleInputChange('description')}
                rows={10}
              />
            </div>
            <div className="o-grid-12">
              <Textarea
                value={formState.qualifications}
                label={phrase('field_label_qualifications', 'Qualifications')}
                name="assignment_qualifications"
                onChange={handleInputChange('qualifications')}
                rows={4}
              />
            </div>
            <div className="o-grid-12">
              <Textarea
                value={formState.benefits}
                label={phrase('field_label_benefits', 'benefits')}
                name="assignment_benefits"
                onChange={handleInputChange('benefits')}
                rows={1}
              />
            </div>
            <div className="o-grid-6">
              <Field
                value={formState.schedule}
                label={phrase('field_label_schedule', 'Schedule')}
                name="assignment_schedule"
                type="text"
                onChange={handleInputChange('schedule')}
              />
            </div>
            <div className="o-grid-6">
              <Field
                value={formState.totalSpots?.toString() ?? ''}
                label={phrase('field_label_spots', 'Total spots')}
                name="assignment_total_spots"
                type={'number'}
                onChange={handleInputChange('totalSpots')}
              />
            </div>

            {LocationFields}
            {ContactFields}
            {EmployerFields}
            {SignUpFields}
            <div className="o-grid-12 u-margin__top--2">
              <Button
                color="primary"
                onClick={() =>
                  onSubmit({
                    title,
                    description,
                    employer,
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
