import { reactive } from "vue";
import { io } from 'socket.io-client';

// Here our state will be declared
export const socketState = reactive({
  connected: false,
  events: []
});

// You can specify here the url for the sockets backend
const url = "http://localhost:8000"

// Create the socket connection
export const socket = io(url);

// Here we will manage the different events

// Change connected state
socket.on("connect", () => {
  state.connected = true;
});

socket.on("disconnect", () => {
  state.connected = false;
});

// Handle backend events

// Add an event to our queue
socket.on("addEvent", (item) => {
    state.events.push(item);
});

// Replace an event in the queue
socket.on("updateEvent", (item) => {
    state.events = state.events.filter((event) => event.id !== item.id);
    state.events.push(item);
});

// Delete and Event in the queue
socket.on("deleteEvent", (item) => {
    state.events= state.events.filter((event) => event.id !== item.id);
});
