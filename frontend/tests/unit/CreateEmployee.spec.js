import { shallowMount } from '@vue/test-utils'
import CreateEmployee from '@/views/CreateEmployee.vue'
import EmployeeForm from '@/components/EmployeeForm.vue'

describe('CreateEmployee.vue', () => {
  it('renders create employee page', () => {
    const wrapper = shallowMount(CreateEmployee, { components: {EmployeeForm}})

    expect(wrapper.html()).toMatchSnapshot()
  })
    
    
  it('renders Employee form ', () => {
    const wrapper = shallowMount(CreateEmployee)
    expect(wrapper.findAllComponents(EmployeeForm)).toHaveLength(1)
  })
})
