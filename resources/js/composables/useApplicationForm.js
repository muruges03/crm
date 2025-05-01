import { ref } from "vue";
import axios from "axios";
import { router } from '@inertiajs/vue3';



export default function useApplicationForm(emit) {
    const form = ref({
        entity_id: "",
        legal_name: "",
        prefix: "",
        description: "",
        status: 0,
    });

    const errors = ref({
        legal_name: "",
        prefix: "",
        description: "",
        status: "",
    });

    const Status = [
        { id: 0, label: "Inactive" },
        { id: 1, label: "Active" },
    ];


    const validateStep = () => {
        errors.value = {};


            if (!form.value.legal_name) errors.value.legal_name = "Legal Name is required.";
            // if (!form.value.prefix) errors.value.prefix = "Prefix is required.";
            if (!form.value.description) errors.value.description = "Description is required.";

        return Object.keys(errors.value).length === 0;
    };
    const initialFormState = {
        entity_id: "",
        legal_name: "",
        prefix: "",
        description: "",
        status: null
    };

    const submitForm = () => {
        console.log('fsdf')
        if (validateStep()) {
            axios.post("/support", form.value)
                .then(() => {
                    window.location.href = '/support';
                })
                .catch((err) => console.log(err));
        }
    };
    const back = () => {
        window.location.href = '/support';
    };
    return {
        form,
        errors,
        Status,
        submitForm,
        back
    };
}
