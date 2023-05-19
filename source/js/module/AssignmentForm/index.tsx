import React from 'react'
import ReactDOM from 'react-dom/client'
import App from './App'

document.addEventListener('DOMContentLoaded', () =>
  [...document.querySelectorAll('.js-assignment-form-app')]
    .map((e) => ({
      root: ReactDOM.createRoot(e as HTMLElement),
      volunteerApiUri: e.getAttribute('data-volunteer-api-uri') ?? '',
      volunteerAppSecret: e.getAttribute('data-volunteer-app-secret') ?? '',
      labels: JSON.parse(e.getAttribute('data-labels') ?? '{}'),
    }))
    .filter(
      ({ volunteerApiUri, volunteerAppSecret }) =>
        volunteerApiUri.length > 0 && volunteerAppSecret.length > 0,
    )
    .forEach(({ root }) => {
      root.render(
        <React.StrictMode>
          <App />
        </React.StrictMode>,
      )
    }),
)
