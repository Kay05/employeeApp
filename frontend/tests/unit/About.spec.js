import { shallowMount } from '@vue/test-utils'
import About from '@/views/About.vue'

describe('About.vue', () => {
  it('renders about page', () => {
    const wrapper = shallowMount(About, {})

    expect(wrapper.html()).toMatchSnapshot()
    expect(wrapper.text()).toMatch('This is an about page')
  })
})
