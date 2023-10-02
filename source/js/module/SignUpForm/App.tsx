import { VolunteerServiceProvider } from '../../volunteer-service/rest/VolunteerServiceProvider'
import PhraseProvider from '../../phrase/PhraseProvider'
import SignUpToAssignment from './SignUpToAssignment'

interface Props {
  volunteerApiUri: string
  volunteerAppSecret: string
  labels?: Record<string, string>
  assignmentId: string
  closeDialog: () => any
  registrationUrl: string
}

function App({
  volunteerApiUri,
  volunteerAppSecret,
  labels,
  assignmentId,
  closeDialog,
  registrationUrl,
}: Props): JSX.Element {
  return (
    <PhraseProvider phrases={labels ?? {}}>
      <VolunteerServiceProvider uri={volunteerApiUri} appSecret={volunteerAppSecret}>
        <div className="assignment-sign-up-app">
          <SignUpToAssignment
            assignmentId={assignmentId}
            closeDialog={closeDialog}
            registrationUrl={registrationUrl}
          />
        </div>
      </VolunteerServiceProvider>
    </PhraseProvider>
  )
}

export default App
