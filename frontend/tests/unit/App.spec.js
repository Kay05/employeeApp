import { shallowMount } from "@vue/test-utils";
import App from "@/App.vue";

const $route = {
  path: '/',
};

const $store = {
  state: { isLoading: false },
  commit: jest.fn(),
};

describe("App.vue", () => {
  it("renders create employee page", () => {
      const wrapper = shallowMount(App, {
        mocks: {
            $route,
        },
      });

    expect(wrapper.html()).toMatchSnapshot();
  });
});
