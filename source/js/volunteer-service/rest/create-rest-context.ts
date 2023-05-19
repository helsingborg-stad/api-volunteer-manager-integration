import axios from 'axios'
import { VolunteerServiceContextType } from '../VolunteerServiceContext'

const post = (uri: string, data: object = {}, headers: object = {}) =>
  axios({
    method: 'post',
    url: `${uri}`,
    data,
    headers,
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
    console.log(r)
    if (!r?.token || r.token.length === 0) throw new Error('Invalid access token')
    return r
  })
const createAuthorizationHeadersFromToken = (token: string) => ({
  'Content-Type': 'application/x-www-form-urlencoded',
  Authorization: `Bearer ${token}`,
})

const createAuthorizationHeadersFromBase64Secret = (base64Secret: string) => ({
  'Content-Type': 'application/x-www-form-urlencoded',
  Authorization: `BASIC ${base64Secret}`,
})

export const createRestContext = (uri: string, appSecret?: string): VolunteerServiceContextType =>
  <VolunteerServiceContextType>{
    getVolunteer: () =>
      getValidAccessToken().then(async ({ token, decoded }) => {
        try {
          const { data } = await get(
            `${uri}/employee`,
            {},
            createAuthorizationHeadersFromToken(token),
          )

          return {
            id: data.meta.first_name,
            firstName: data.meta.first_name,
            lastName: data.meta.surname,
            email: data.meta.email,
            phone: data.meta.phone_number,
            status: data.meta['employee-registration-status'],
          }
        } catch (e) {
          console.log(e)
          return {
            id: decoded?.id ?? '',
            firstName: decoded?.firstName,
            lastName: decoded?.lastName,
            email: '',
            phone: '',
            status: '',
          }
        }
      }),
    registerVolunteer: (input) =>
      getValidAccessToken()
        .then(({ token, decoded }) =>
          post(
            `${uri}/employee`,
            {
              title: 'employee from insomnia',
              status: 'pending',
              email: input.email,
              national_identity_number: decoded?.id ?? '',
              first_name: decoded?.firstName ?? '',
              surname: decoded?.lastName ?? '',
              ...(input?.phoneNumber && input?.phoneNumber.length > 0
                ? {
                    phone_number: input.phoneNumber,
                  }
                : {}),
            },
            createAuthorizationHeadersFromToken(token),
          ),
        )
        .then((response) => ({
          id: response.data.meta.first_name,
          firstName: response.data.meta.first_name,
          lastName: response.data.meta.surname,
          email: response.data.meta.email,
          phone: response.data.meta.phone_number,
          status: response.data.meta['employee-registration-status'],
        })),
    registerAssignment: (input) =>
      post(
        `${uri}'/assignment'`,
        {
          title: input.title,
          status: 'draft',
          slug: '',
          featured_media: 0,
          'assignment-status': [],
          'assignment-category': [],
          'assignment-eligibility': [],
          meta: {
            description: input.description,
            employer_name: input.organisation.name,
            employer_contacts: input.organisation.contacts,
            employer_website: input.organisation.website,
            signup_methods: [input.signUp.type],
            signup_email: input.signUp?.email ?? '',
            signup_phone: input.signUp?.phone ?? '',
            signup_link: input.signUp?.website ?? '',
            qualifications: input?.qualifications ?? '',
            schedule: input?.schedule ?? '',
            benefits: input?.benefits ?? '',
            number_of_available_spots: input.totalSpots ?? '',
            street_address: input?.location?.address ?? '',
            postal_code: input?.location?.postal ?? '',
            city: input?.location?.city ?? '',
            internal_assignment: false,
            assignment_status: false,
            assignment_eligibility: false,
            assignment_category: false,
          },
        },
        createAuthorizationHeadersFromBase64Secret(appSecret ?? ''),
      ).then((response) => ({
        id: response?.data?.id,
        slug: response?.data?.slug,
        status: response?.data?.status,
        title: response?.data?.title,
        description: response?.data?.meta?.description ?? '',
        signUp: {
          type: response?.data?.meta?.signup_methods[0],
          website: response?.data?.meta?.signup_link ?? '',
          phone: response?.data?.meta?.signup_phone ?? '',
          email: response?.data?.meta?.signup_email ?? '',
        },
        qualifications: response?.data?.meta?.qualifications ?? null,
        schedule: response?.data?.meta?.schedule ?? null,
        benefits: response?.data?.meta?.benefits ?? null,
        totalSpots: response?.data?.meta?.number_of_available_spots ?? null,
        location: {
          address: response?.data?.meta?.street_address ?? '',
          postal: response?.data?.meta?.postal_code ?? '',
          city: response?.data?.meta?.city ?? '',
        },
      })),
  }
