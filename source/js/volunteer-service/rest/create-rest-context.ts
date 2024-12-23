import axios from 'axios'
import {
  SignUpTypes,
  VOLUNTEER_ERROR,
  VolunteerServiceContextType,
} from '../VolunteerServiceContext'
import { GetAccessTokenResponse } from '../../gdi-host/api'
import { convertToFormData } from '../../util/convert-to-form-data'
import { capitalizeName } from '../../util/capitalize'

const post = (uri: string, data: FormData | object = {}, headers: object = {}) =>
  axios({
    method: 'post',
    url: `${uri}`,
    data,
    headers: {
      ...{ 'Content-Type': 'application/x-www-form-urlencoded' },
      ...headers,
      ...(data instanceof FormData ? { 'Content-Type': 'multipart/form-data' } : {}),
    },
  })

const get = (uri: string, data: object = {}, headers: object = {}) =>
  axios({
    method: 'get',
    url: `${uri}`,
    data,
    headers,
  })

export const tryGetAccessToken = async () => window.gdiHost.getAccessToken()

export const getValidAccessToken = async () =>
  tryGetAccessToken().then((r) => {
    if (!r?.token || r.token.length === 0) throw new Error('Invalid access token')
    return r
  })

const createAuthorizationHeadersFromToken = ({ token }: GetAccessTokenResponse) => ({
  Authorization: `Bearer ${token}`,
})

const createAuthorizationHeadersFromBase64Secret = (base64Secret: string) => ({
  Authorization: `${base64Secret}`,
})

export const createRestContext = (
  uri: string,
  appSecret?: string,
): VolunteerServiceContextType => ({
  getVolunteer: () =>
    getValidAccessToken()
      .then(createAuthorizationHeadersFromToken)
      .then((headers) => get(`${uri}/employee`, {}, headers))
      .then(({ data }) => ({
        id: data.national_identity_number,
        firstName: capitalizeName(data.first_name),
        lastName: capitalizeName(data.surname),
        email: data.email,
        phone: data.phone_number,
        status: data.status.slug,
        statusLabel: data.status.name,
        assignments: [...(data?.assignments ?? [])].map(
          ({ id, title, status: { name, slug } }) => ({
            assignmentId: id,
            title: title,
            status: slug,
            statusLabel: name,
          }),
        ),
        newsletter: data.newsletter,
      }))
      .catch((err: any) => {
        if (err?.response?.status && err?.response?.data?.code) {
          if (err.response.status === 404 && err.response.data.code === 'rest_post_invalid_id') {
            let error = new Error("Volunteer doesn't exist")
            error.name = VOLUNTEER_ERROR.VOLUNTEER_DOES_NOT_EXIST
            throw error
          }
        }
        throw err
      }),
  registerVolunteer: (input) =>
    getValidAccessToken()
      .then(createAuthorizationHeadersFromToken)
      .then((headers) =>
        post(
          `${uri}/employee`,
          {
            email: input.email,
            phone_number: input.phone,
            newsletter: input.newsletter ? true : null,
          },
          headers,
        ),
      )
      .then((response) => ({
        id: response.data.national_identity_number ?? input.id,
        firstName: capitalizeName(response.data.first_name ?? input.firstName),
        lastName: capitalizeName(response.data.surname ?? input.lastName),
        email: response.data.email ?? input.email,
        phone: response.data.phone_number ?? input.phone,
        newsletter: response.data.newsletter ?? input.newsletter,
        status: response.data.status.slug ?? 'submitted',
      })),
  registerAssignment: (input) =>
    post(
      `${uri}/assignment`,
      convertToFormData({
        title: input.title,
        assignment_eligibility: '[]',
        description: input.description,
        qualifications: input.qualifications ?? '',
        end_date: input.endDate ?? '',
        schedule:
          input.schedule ?? [input.when, input.where].filter((v) => v && v.length > 0).join('\n\n'),
        benefits: input.benefits ?? '',
        number_of_available_spots: input.totalSpots?.toString() ?? '',
        signup_methods: [],
        featured_media: input?.image?.item(0) || null,
        internal_assignment: input.signUp.type === SignUpTypes.Internal ? 'true' : 'false',
        signup_link: input.signUp.type === SignUpTypes.Link ? input.signUp.link ?? '' : '',
        signup_email:
          input.signUp.type === SignUpTypes.Contact ? input.publicContact?.email ?? '' : '',
        signup_phone:
          input.signUp.phone === SignUpTypes.Contact ? input.publicContact?.phone ?? '' : '',
        submitted_by_first_name: input.employer.contacts[0].name,
        submitted_by_email: input.employer.contacts[0].email ?? '',
        submitted_by_phone: input.employer.contacts[0].phone ?? '',
        employer_name: input.employer.name,
        employer_website: input.employer.website ?? '',
        employer_about: input.employer.about ?? '',
        employer_contacts: input.publicContact
          ? [
              {
                name: input.publicContact?.name ?? '',
                email: input.publicContact?.email ?? '',
                phone: input.publicContact?.phone ?? '',
              },
            ]
          : null,
        street_address: input.location?.address ?? '',
        postal_code: input.location?.postal ?? '',
        city: input.location?.city ?? '',
      }),
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
  applyToAssignment: (assignmentId) =>
    getValidAccessToken()
      .then(createAuthorizationHeadersFromToken)
      .then((headers) => post(`${uri}/application`, { assignment_id: assignmentId }, headers))
      .then(({ status, statusText }) => {
        if (status !== 200) {
          throw new Error(statusText)
        }
      }),
  getAssignment: (assignmentId) =>
    get(`${uri}/assignment/${assignmentId}`).then(({ data }) => ({
      id: data.id,
      title: data.title,
      description: data.meta.description,
      qualifications: data.meta.qualifications,
      schedule: data.meta.schedule,
      benefits: data.meta.benefits,
      totalSpots: data.meta.number_of_available_spots,
      signUp: {
        type: data.meta.internal_assignment
          ? SignUpTypes.Internal
          : data.meta.signup_methods[0] || null,
        link: data.meta.signup_link,
        email: data.meta.signup_email,
        phone: data.meta.signup_phone,
      },
      employer: {
        name: data?.meta?.employer_name || '',
        website: data?.meta?.employer_website || '',
        contacts: [
          {
            name: '',
            email: '',
            phone: '',
          },
        ],
      },
    })),
})
