import { ref, watchEffect } from "vue";
import axios from "axios";
import { Inertia } from "@inertiajs/inertia";

export default function useSupportForm(props, emit) {
    const form = ref({
        service_type: "",
        service_by: "",
        description: { ops: [] },
        date: "",
        tat_date: "",
        status: 0,
        customer_id: "",
        tat_level: "",
        made_by: "",
        client_name:'',
        application_id:''
    });
    const id = ref(0);

    watchEffect(() => {
        const data = Array.isArray(props.EditData) ? props.EditData[0] : props.EditData;
        if (data) {
            form.value = {
                service_type: data.service_type || "",
                service_by: data.service_by || "",
                made_by: data.made_by || "",
                description: data.description,
                date: data.date || "",
                tat_date: data.tat_date
                    ? new Date(data.tat_date).toISOString().slice(0, 16)
                    : "",
                status: data.status || 0,
                customer_id: data.customer_id || "",
                tat_level: data.tat_level || "",
                application_id: data.application_id || "",
                client_name: data.client_name || "",
            };
            id.value = data.id || 1;
        }
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
            if (!form.value.application_id) errors.value.application_id = "Please select a application.";
            if (!form.value.client_name) errors.value.client_name = "Please enter client Name.";
            if (!form.value.customer_id) errors.value.customer_id = "Please select a customer.";
        return Object.keys(errors.value).length === 0;
    };

const back = () => {
    Inertia.get('/support')
}
    const UpdateForm = () => {
        if (validateStep()) {

            axios.post(`/supportSystem/${id.value}`, {
                ...form.value,
                _method: "PUT",
            })
                .then(() => {
                    window.location.href = "/support";
                })
                .catch(() => emit("update:SupportSystem", "Try Again Later"));
        }
    };

    return {
        form,
        errors,
        id,
        Status,
        back,
        validateStep,
        UpdateForm,
    };
}
