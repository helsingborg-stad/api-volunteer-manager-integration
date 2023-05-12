import { VolunteerServiceProvider } from '../../volunteer-service/rest/VolunteerServiceProvider'
import PhraseProvider from '../../phrase/PhraseProvider'
import RegisterVolunteer from './components/RegisterVolunteer'

interface Props {
  volunteerApiUri: string
  labels?: Record<string, string>
}

function App({ volunteerApiUri, labels }: Props): JSX.Element {
  return (
    <PhraseProvider phrases={labels ?? {}}>
      <VolunteerServiceProvider uri={volunteerApiUri}>
        <div className="volunteer-form-app">
          <RegisterVolunteer />
        </div>
      </VolunteerServiceProvider>
    </PhraseProvider>
  )
}

export default App
