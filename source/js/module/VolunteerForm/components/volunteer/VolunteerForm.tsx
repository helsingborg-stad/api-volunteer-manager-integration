import { Button, Card, CardBody, Field } from '@helsingborg-stad/municipio-react-ui'
import { Volunteer, VolunteerInput } from '../../../../volunteer-service/VolunteerServiceContext'
import PhraseContext from '../../../../phrase/PhraseContext'
import { useContext, useState } from 'react'

interface VolunteerFormProps {
  volunteer: Volunteer
  onSubmit: (input: VolunteerInput) => any
}

function VolunteerForm({ volunteer, onSubmit }: VolunteerFormProps): JSX.Element {
  const { firstName, lastName, id } = volunteer || { firstName: '', lastName: '', id: '' }
  const { phrase } = useContext(PhraseContext)

  const [email, setEmail] = useState('')
  const [phoneNumber, setPhoneNumber] = useState('')

  return (
    <Card>
      <CardBody>
        <form>
          <div className="o-grid o-grid--form">
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
            <div className="o-grid-12">
              <Field
                value={email}
                label={phrase('email', 'E-mail address')}
                name="volunteer-email"
                type="email"
                required
                onChange={(e) => setEmail(e.target.value)}
              />
            </div>
            <div className="o-grid-12">
              <Field
                value={phoneNumber}
                label={phrase('phone', 'Phone number')}
                name="volunteer-phone"
                type="phone"
                required
                onChange={(e) => setPhoneNumber(e.target.value)}
              />
            </div>
            <div className="o-grid-12">
              <Button
                onClick={() =>
                  onSubmit({
                    email,
                    phoneNumber,
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

export default VolunteerForm
