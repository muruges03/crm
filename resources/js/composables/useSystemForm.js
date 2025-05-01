import { ref, inject } from "vue";
import axios from "axios";

export default function useSystemForm(emit) {
    const ServiceType = inject("ServiceType", []);
    const ServiceBy = inject("ServiceBy", []);
    const Customers = inject("Customers", []);
    const UserGrp = inject("UserGrp", []);
    const Application = inject("Application", []);

    const form = ref({
        service_type: "",
        service_by: "",
        description: "",
        date: "",
        tat_date: "",
        status: 0,
        customer_id: "",
        tat_level: "",
        made_by: "",
        application_id:'',
        client_name:''
    });

    const errors = ref({});

    const Status = [
        { id: 0, label: "Incomplete" },
        { id: 1, label: "Complete" },
    ];

    const validateStep = () => {
        errors.value = {};
            if (!form.value.service_type) errors.value.service_type = "Service type is required.";
            if (!form.value.service_by) errors.value.service_by = "Service provider is required.";
            if (!form.value.description) errors.value.description = "Please provide a description.";
            if (!form.value.date) errors.value.date = "Please select a start date.";
            if (!form.value.tat_date) errors.value.tat_date = "Please select a turnaround time.";
            if (form.value.status === "") errors.value.status = "Please select a status.";
            if (!form.value.tat_level) errors.value.tat_level = "Please select tat level.";
            if (!form.value.made_by) errors.value.made_by = "Please select a group.";
            if (!form.value.application_id) errors.value.application_id = "Please select a application.";
            if (!form.value.client_name) errors.value.client_name = "Please enter client Name.";
            if (!form.value.customer_id) errors.value.customer_id = "Please select a customer.";
        return Object.keys(errors.value).length === 0;
    };
    const back =  ()  => {
        emit("update:viewemit")
    }


    const submitForm = () => {
        if (validateStep()) {
            axios.post("/supportSystem", form.value)
                .then(() => emit("update:SupportSystem", 'Support Ticket Created Successfully'))
                .catch(() => emit("update:SupportSystem", 'Try After Some Time'));
        }
    };

    return {
        form,
        errors,
        ServiceType,
        ServiceBy,
        Customers,
        UserGrp,
        Status,
        Application,
        validateStep,
        submitForm,
        back
    };
}
