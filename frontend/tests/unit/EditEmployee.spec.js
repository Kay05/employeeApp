import { shallowMount } from "@vue/test-utils";
import EditEmployee from "@/views/EditEmployee.vue";
import EmployeeForm from "@/components/EmployeeForm.vue";
import LoadingOverlay from "@/components/LoadingOverlay.vue";

const $route = {
  params: { employee_id: 1 },
};

const $store = {
  state: { isLoading: false },
  commit: jest.fn(),
};

describe("EditEmployee.vue", () => {
  it("renders create employee page", () => {
    const wrapper = shallowMount(EditEmployee, {
      mocks: {
        $route,
        $store,
      },
      components: { EmployeeForm },
    });

    expect(wrapper.html()).toMatchSnapshot();
  });

  it("renders Employee form ", () => {
    const wrapper = shallowMount(EditEmployee, {
      mocks: {
        $route,
        $store,
      },
      components: { EmployeeForm },
    });
    expect(wrapper.findAllComponents(EmployeeForm)).toHaveLength(1);
  });
    
  it("renders loadingoverlay form ", () => {
    const wrapper = shallowMount(EditEmployee, {
      mocks: {
        $route,
        $store,
      },
      components: { LoadingOverlay },
    });
    expect(wrapper.findAllComponents(LoadingOverlay)).toHaveLength(1);
  });

  it("update state", () => {
    const action = jest.fn();
    const $store = {
      state: { isLoading: false },
      commit: action,
    };
    const wrapper = shallowMount(EditEmployee, {
      mocks: {
        $route,
        $store,
      },
      components: { EmployeeForm },
    });
    expect(action).toHaveBeenCalled();
  });

  it("calls service", () => {
    jest.mock("axios", () => {
      return {
        get: jest.fn(() =>
          Promise.resolve({
            data: {
              data: [{}],
            },
          })
        ),
      };
    });
    const wrapper = shallowMount(EditEmployee, {
      mocks: {
        $route,
        $store,
      },
      components: { EmployeeForm },
    });
    wrapper.vm.getEmployee();
    expect(wrapper.vm.link).toEqual("");
  });
});
