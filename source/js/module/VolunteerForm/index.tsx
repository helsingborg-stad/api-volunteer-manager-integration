import React from 'react'
import ReactDOM from 'react-dom/client'
import App from './App'

document.addEventListener('DOMContentLoaded', () =>
  [...document.querySelectorAll('.js-volunteer-form')]
    .map((e) => ({
      root: ReactDOM.createRoot(e as HTMLElement),
      volunteerApiUri: e.getAttribute('data-volunteer-api-uri') ?? '',
      labels: JSON.parse(e.getAttribute('data-labels') ?? '{}'),
    }))
    .filter(({ volunteerApiUri }) => volunteerApiUri.length > 0)
    .forEach(({ root, volunteerApiUri, labels }) => {
      root.render(
        <React.StrictMode>
          <App volunteerApiUri={volunteerApiUri} labels={labels} />
        </React.StrictMode>,
      )
    }),
)
