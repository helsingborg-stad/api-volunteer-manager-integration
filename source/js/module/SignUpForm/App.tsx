import { VolunteerServiceProvider } from '../../volunteer-service/rest/VolunteerServiceProvider'
import PhraseProvider from '../../phrase/PhraseProvider'
import SignUpToAssignment from './SignUpToAssignment'

interface Props {
  volunteerApiUri: string
  volunteerAppSecret: string
  labels?: Record<string, string>
}

function App({ volunteerApiUri, volunteerAppSecret, labels }: Props): JSX.Element {
  return (
    <PhraseProvider phrases={labels ?? {}}>
      <VolunteerServiceProvider uri={volunteerApiUri} appSecret={volunteerAppSecret}>
        <div className="assignment-sign-up-app">
          <SignUpToAssignment />
        </div>
      </VolunteerServiceProvider>
    </PhraseProvider>
  )
}

export default App
