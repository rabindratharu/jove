import { persist } from "zustand/middleware"; // Import persist middleware
import { createStore } from "zustand/vanilla"; // Correctly import createStore

const stores = [];

// Add the store and persist function to the window object for access in global scope
window.zustand = {
	persist,
	createStore,
	stores, // stores array will hold your Zustand store
};
