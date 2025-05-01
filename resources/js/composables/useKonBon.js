import { computed, onMounted } from "vue";
import { ref } from "vue";
import Swal from "sweetalert2";

export default function useKonBon(props){
const TicketSystemData = ref([...props.TicketSystem]);

const tatOptions = [

   { "id": "Service Call", "label": "Service Call" },
   { "id": "Requirement", "label": "Requirement" },
   { "id": "Possible", "label": "Possible" },
   { "id": "Not Possible", "label": "Not Possible" },
   { "id": "Testing", "label": "Testing" },
   { "id": "Deployed", "label": "Deployed" },
   { "id": "Done", "label": "Done" },
];
const ticketsByTatLevel = computed(() => {
    let groupedTickets = tatOptions.reduce((acc, option) => {
        acc[option.id] = [];
        return acc;
    }, {});

    TicketSystemData.value.forEach(ticket => {
        if (ticket.tat_level && groupedTickets[ticket.tat_level]) {
            groupedTickets[ticket.tat_level].push(ticket);
        }
    });

    return groupedTickets;
});


const onDrop = async (event) => {
    const { item, to } = event;

    const movedTicketId = item.dataset.id;
    const newLevel = to.dataset.level;

    try {
        await axios.put(`/supportSystem-tat/${movedTicketId}`, { tat_level: newLevel });
        TicketSystemData.value = TicketSystemData.value.map(ticket =>
            ticket.id == movedTicketId ? { ...ticket, tat_level: newLevel } : ticket
        );
    } catch (error) {
        console.error("Error updating ticket status:", error);
    }
};


const updateTatLevel = async (ticket) => {
    try {
        await axios.put(`/supportSystem-tat/${ticket.id}`, { tat_level: ticket.tat_level });
    } catch (error) {
        console.error("Error updating ticket status:", error);
    }
};

const destroy = async (id) => {
    const result = await Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to undo this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, Delete!"
    });

    if (result.isConfirmed) {
        try {
            await axios.delete(`/supportSystem/${id}`);
            TicketSystemData.value = TicketSystemData.value.filter(ticket => ticket.id !== id);
        } catch (error) {
            console.error("Error deleting ticket:", error);
        }
    }
};

const fetchTickets = async () => {
    try {
        const response = await axios.get("/api/support-tickets");
        TicketSystemData.value = response.data;
    } catch (error) {
        console.error("Failed to fetch ticket system data:", error);
    } finally {
    }
};

onMounted(fetchTickets);


return {
    fetchTickets,
    destroy,
    updateTatLevel,
    onDrop,
    ticketsByTatLevel,
    tatOptions,
    TicketSystemData,
}
}
