import axios from 'axios'
import { SignUpTypes, VolunteerServiceContextType } from '../VolunteerServiceContext'

const post = (uri: string, data: object = {}, headers: object = {}) =>
  axios({
    method: 'post',
    url: `${uri}`,
    data,
    headers,
    validateStatus: function (status) {
      return status >= 200 && status < 400
    },
  })

const get = (uri: string, data: object = {}, headers: object = {}) =>
  axios({
    method: 'get',
    url: `${uri}`,
    data,
    headers,
  })

const tryGetAccessToken = async () => window.gdiHost.getAccessToken()
const getValidAccessToken = async () =>
  tryGetAccessToken().then((r) => {
    if (!r?.token || r.token.length === 0) throw new Error('Invalid access token')
    return r
  })
const createAuthorizationHeadersFromToken = (token: string) => ({
  'Content-Type': 'application/x-www-form-urlencoded',
  Authorization: `Bearer ${token}`,
})

const createAuthorizationHeadersFromBase64Secret = (base64Secret: string) => ({
  'Content-Type': 'application/x-www-form-urlencoded',
  Authorization: `${base64Secret}`,
})

export const createRestContext = (
  uri: string,
  appSecret?: string,
): VolunteerServiceContextType => ({
  getVolunteer: () =>
    getValidAccessToken().then(async ({ token, decoded }) => {
      const { data } = await get(`${uri}/employee`, {}, createAuthorizationHeadersFromToken(token))
      return {
        id: data.national_identity_number,
        firstName: data.first_name,
        lastName: data.surname,
        email: data.email,
        phone: data.phone_number,
        status: data.status.slug,
      }
    }),
  registerVolunteer: (input) =>
    getValidAccessToken()
      .then(({ token, decoded }) =>
        post(
          `${uri}/employee`,
          {
            email: input.email,
            phone_number: input.phone,
          },
          createAuthorizationHeadersFromToken(token),
        ),
      )
      .then((response) => ({
        id: response.data.national_identity_number ?? input.id,
        firstName: response.data.first_name ?? input.firstName,
        lastName: response.data.surname ?? input.lastName,
        email: response.data.email ?? input.email,
        phone: response.data.phone_number ?? input.phone,
        status: response.data.status.slug ?? 'submitted',
      })),
  registerAssignment: (input) =>
    post(
      `${uri}/assignment`,
      {
        title: input.title,
        assignment_eligibility: '[]',
        description: input.description,
        qualifications: input.qualifications ?? null,
        schedule:
          input.schedule ?? [input.when, input.where].filter((v) => v && v.length > 0).join('\n\n'),
        benefits: input.benefits ?? null,
        number_of_available_spots: input.totalSpots ?? null,
        signup_methods: [],
        ...(input.signUp.type === SignUpTypes.Internal
          ? {
              internal_assignment: 'true',
            }
          : {}),
        ...(input.signUp.type === SignUpTypes.Link
          ? {
              internal_assignment: 'false',
              signup_methods: ['link'],
              signup_link: input.signUp.link,
            }
          : {}),
        ...(input.signUp.type === SignUpTypes.Contact
          ? {
              internal_assignment: 'false',
              signup_methods: [
                ...(input.signUp.email && input.signUp.email.length > 0 ? ['email'] : []),
                ...(input.signUp.phone && input.signUp.phone.length > 0 ? ['phone'] : []),
              ],
              ...{
                ...(input.signUp.email && input.signUp.email.length > 0
                  ? { signup_email: input.signUp.email }
                  : {}),
                ...(input.signUp.phone && input.signUp.phone.length > 0
                  ? { signup_phone: input.signUp.phone }
                  : {}),
              },
            }
          : {}),
        submitted_by_first_name: input.employer.contacts[0].name,
        submitted_by_email: input.employer.contacts[0].email,
        submitted_by_phone: input.employer.contacts[0].phone,
        employer_name: input.employer.name,
        ...(input?.employer?.website?.length && input?.employer.website.length > 0
          ? { employer_website: input.employer.website }
          : {}),
        ...(input?.employer?.about?.length && input?.employer.about.length > 0
          ? { employer_about: input.employer.about }
          : {}),
        ...(input?.publicContact && (input.publicContact?.email || input.publicContact?.phone)
          ? {
              employer_contacts: [
                {
                  name: input?.publicContact?.name ?? '',
                  email: input?.publicContact?.email ?? '',
                  phone: input?.publicContact?.phone ?? '',
                },
              ],
            }
          : {}),
      },
      createAuthorizationHeadersFromBase64Secret(appSecret ?? ''),
    ).then((response) => {
      if (response.status !== 200 || !response?.data?.assignment_id) {
        throw new Error('Something went wrong')
      }

      const toNullString = (key: string, target?: string | number) =>
        !target || target === 0 || (typeof target === 'string' && target.length === 0)
          ? { [key]: '-' }
          : {}

      return {
        ...input,
        id: response.data.assignment_id,
        ...toNullString('benefits', input?.benefits),
        ...toNullString('qualifications', input?.qualifications),
        ...toNullString('readMoreLink', input?.readMoreLink),
        ...toNullString('totalSpots', input?.totalSpots),
        ...toNullString('when', input?.when),
        ...toNullString('where', input?.where),
      }
    }),
})
