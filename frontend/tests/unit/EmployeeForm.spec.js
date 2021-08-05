import { shallowMount } from '@vue/test-utils'
import EmployeeForm from '@/components/EmployeeForm.vue'

describe('EmployeeForm.vue', () => {
  it('renders props.msg when passed', () => {
    const link = 'testLink'
    const obj =  {
                first_name: '',
                last_name: '',
                contact_number: '',
                email: '',
                address: '',
                dob: null,
                city: '',
                postal_code: '',
                country: '',
                skills: [
                    {
                        name: '',
                        pivot: {
                            experience: '',
                            rating: ''
                        }
                    }
                ],
            }
    const edit = false
    const wrapper = shallowMount(EmployeeForm, {
      propsData: { actionLink: link, employee: obj, edit: edit }
    })

    expect(wrapper.html()).toMatchSnapshot()
    expect(wrapper.text()).toMatch('Save and Add Employee')
  })
    
  it("should render the new skill btn and the menu", () => {
    const link = 'testLink'
    const obj =  {
                first_name: '',
                last_name: '',
                contact_number: '',
                email: '',
                address: '',
                dob: null,
                city: '',
                postal_code: '',
                country: '',
                skills: [
                    {
                        name: '',
                        pivot: {
                            experience: '',
                            rating: ''
                        }
                    }
                ],
            }
    const edit = false
    const wrapper = shallowMount(EmployeeForm, {
      propsData: { actionLink: link, employee: obj, edit: edit }
    })  
    // to make sure we are free from vuetify components in our tests, use data-testid attributes to search for elements
    expect(wrapper.find('[data-testid="increment-newskill"]').exists()).toBe(
      true
    );
    expect(wrapper.find('[data-testid="increment-menu"]').exists()).toBe(true)
    expect(wrapper.find('[data-testid="increment-btn-major"]').exists()).toBe(true)
  });
    
  it('diplay alert when activated', () => {
    const link = 'testLink'
    const obj =  {
                first_name: '',
                last_name: '',
                contact_number: '',
                email: '',
                address: '',
                dob: null,
                city: '',
                postal_code: '',
                country: '',
                skills: [
                    {
                        name: '',
                        pivot: {
                            experience: '',
                            rating: ''
                        }
                    }
                ],
            }
    const edit = false
    const wrapper = shallowMount(EmployeeForm, {
      propsData: { actionLink: link, employee: obj, edit: edit }
    }) 
    wrapper.setData({ alert: { active: true, message: 'Test' } });
    expect(wrapper.find('.v-alert--border').exists()).toBe(false);
  });
})
