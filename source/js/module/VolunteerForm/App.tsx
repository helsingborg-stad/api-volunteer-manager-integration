import { VolunteerServiceProvider } from '../../volunteer-service/rest/VolunteerServiceProvider'
import PhraseProvider from '../../phrase/PhraseProvider'
import RegisterVolunteer from './components/RegisterVolunteer'

function App(): JSX.Element {
  return (
    <PhraseProvider phrases={{}}>
      <VolunteerServiceProvider uri={'https://modul-test.helsingborg.io/volontar/wp-json/wp/v2/'}>
        <div className="volunteer-form-app">
          <RegisterVolunteer />
        </div>
      </VolunteerServiceProvider>
    </PhraseProvider>
  )
}

export default App
