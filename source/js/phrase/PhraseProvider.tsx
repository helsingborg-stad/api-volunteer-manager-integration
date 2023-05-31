import PhraseContext from './PhraseContextInterface'

type PhraseProviderProps = {
  phrases?: Record<string, string>
  children: JSX.Element[] | JSX.Element
}

const PhraseProvider = ({ phrases = {}, children }: PhraseProviderProps): JSX.Element => {
  const phrase = (key: string, defaultPhrase: string) => phrases[key] ?? defaultPhrase
  return <PhraseContext.Provider value={{ phrase }}>{children}</PhraseContext.Provider>
}

export default PhraseProvider
