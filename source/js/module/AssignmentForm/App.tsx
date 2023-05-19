import { VolunteerServiceProvider } from '../../volunteer-service/rest/VolunteerServiceProvider'
import PhraseProvider from '../../phrase/PhraseProvider'
import RegisterAssignment from './components/RegisterAssignment'

interface Props {
  volunteerApiUri: string
  volunteerAppSecret: string
  labels?: Record<string, string>
}

function App({ volunteerApiUri, volunteerAppSecret, labels }: Props): JSX.Element {
  return (
    <PhraseProvider phrases={labels ?? {}}>
      <VolunteerServiceProvider uri={volunteerApiUri} appSecret={volunteerAppSecret}>
        <div className="assignment-form-app">
          <RegisterAssignment />
        </div>
      </VolunteerServiceProvider>
    </PhraseProvider>
  )
}

export default App
