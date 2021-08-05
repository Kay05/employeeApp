import { mount, createLocalVue } from '@vue/test-utils';
import Vuetify from 'vuetify';
import LoadingOverlay from '@/components/LoadingOverlay.vue';


describe('LoadingOverlay.vue', () => {
  let localVue;
  let vuetify;
  let wrapper;

  beforeEach(() => {
    localVue = createLocalVue(); // because of vuetify, we should use a localVue instance
    vuetify = new Vuetify();
    wrapper = mount(LoadingOverlay, {
      localVue,
      vuetify,
      propsData: {loading: true}
    });
  });
  it('should render the overlay and the progress', () => {
    // to make sure we are free from vuetify components in our tests, use data-testid attributes to search for elements
    expect(wrapper.find('[data-testid="increment-overlay"]').exists()).toBe(true)
  })
})

// import { shallowMount } from '@vue/test-utils'
// import LoadingOverlay from '@/components/LoadingOverlay.vue';

// describe('LoadingOverlay.vue', () => {
//   it('renders about page', () => {
//     const wrapper = shallowMount(LoadingOverlay, {
//       propsData: { loading: true }
//     })

//     expect(wrapper.html()).toMatchSnapshot()
//     // expect(wrapper.text()).toMatch('This is an about page')
//   })
// })


