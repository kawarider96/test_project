import { createProject, fetchProjects, exportProjects } from "./projectFunctions";
import { createProjectTime, fetchProjectTimes, updateProjectTime } from "./projectTimesFunctions";

class ProjectModal {
    constructor(projectId) {
        this.projectId = projectId; //aktuális project azonositó
        this.currentProjectTimeId = null; //aktuális idősáv rekord azonosítója
        this.project_start = null;  //project kezdete
        this.project_end = null; //project vége
        this.totalElapsedTime = 0; //inditástól eltelt idő a számláló megjelenítéséhez kell
        this.timerState = false; // A számláló futásának állapota
        this.dialogElement = document.getElementById('dialog');
        this.timerElement = document.getElementById('timer');
        this.commentElement = document.getElementById('project-comment');
        this.projectNameElement = document.getElementById('project-name'); // Projekt neve
    }

    async init() {
        await this.createNewProjectTime(); //létrehoz egy új idősáv rekordot az adott project id-hez kapcsolva
        this.setTimerDisplay(); //számláló elem értékének beállítása
        this.addEventListeners(); //eseménykezelők hozzárendelése
    }

    //idősáv rekord létrehozása
    async createNewProjectTime() {
        try {
            const response = await createProjectTime(this.projectId, null, null, null);
    
            // Új idősáv hozzáadása a tömbhöz
            this.dialogElement.dataset.projectTimeId = response.id;
            this.currentProjectTimeId = response.id;

        } catch (error) {
            console.error("Error creating new project time:", error);
        }
    }    
    
    //számláló elem értékének beállítása
    setTimerDisplay() {
        if (this.timerElement) {
            this.timerElement.textContent = this.formatElapsedTime(this.totalElapsedTime);
        }
    }

    //eseménykezelők hozzárendelése
    addEventListeners() {
        const startButton = document.getElementById("start-button");
        const stopButton = document.getElementById("stop-button");
        const closeButton = document.getElementById("close-button");
    
        startButton.addEventListener("click", () => this.startTimer());
        stopButton.addEventListener("click", () => this.stopTimer());
        closeButton.addEventListener("click", () => this.closeDialog());
    
        this.commentElement.addEventListener("blur", () => this.saveComment());
    }

    //start és end közt eltelt idő kiszámítása
    calculateElapsedTime() {
        if (this.project_start && this.project_end) {
            const start = new Date(this.project_start);
            const end = new Date(this.project_end);
            this.totalElapsedTime = (end - start) / 1000; // Másodpercben
        } else {
            this.totalElapsedTime = 0;
        }
    }
    
    //másodpercek átalakítása HH:PP:MM formátumra
    formatElapsedTime(seconds) {
        const hours = Math.floor(seconds / 3600);
        const minutes = Math.floor((seconds % 3600) / 60);
        const secs = Math.floor(seconds % 60);
        return `${hours.toString().padStart(2, "0")}:${minutes
            .toString()
            .padStart(2, "0")}:${secs.toString().padStart(2, "0")}`;
    }

    //időzítő indítása
    startTimer() {
        if (this.timerState) return; // Ha már fut, ne indítsuk újra
    
        this.timerState = true; // Frissítsük az állapotot, hogy az időzítő fut
    
        // Csak akkor mentse a kezdési időt, ha még nincs beállítva
        if (!this.project_start) {
            this.project_start = new Date();
            this.saveStartTime(this.project_start);
        }
    
        // Indítsuk el a számlálót
        this.timerInterval = setInterval(() => {
            this.totalElapsedTime += 1; // Másodpercenként növeljük az eltelt időt
            this.setTimerDisplay(); // Frissítjük a számláló kijelzőt
        }, 1000);
    
        this.updateButtonStates();
    }
    
    //kezdeti idő mentése
    async saveStartTime(startTime) {

        if (!this.currentProjectTimeId) {
            console.error("Nincs projectTime ID a mentéshez!");
            return;
        }

        try {
            await updateProjectTime(this.currentProjectTimeId, { project_start: startTime.toISOString().slice(0, 19).replace("T", " ") });
            console.log("Idősáv kezdete mentve:", startTime);
        } catch (error) {
            console.error("Hiba történt az idősáv mentésekor:", error);
        }
    }

    //időzítő zárása
    stopTimer() {
        if (!this.timerState) return; // Ha nem fut a számláló, ne csináljon semmit
    
        this.timerState = false; // Állapot frissítése
    
        // Állítsuk le a számlálót
        clearInterval(this.timerInterval);
        this.timerInterval = null;
    
        // Csak akkor mentse a zárási időt, ha a kezdési idő létezik
        if (this.project_start) {
            this.project_end = new Date(this.project_start.getTime() + this.totalElapsedTime * 1000); // Helyes zárási idő
            this.saveEndTime(this.project_end); // Mentjük a zárási időt
        } else {
            console.error("Nem található érvényes project_start az aktuális idősávhoz.");
        }
    
        this.updateButtonStates(); // Gombok állapotának frissítése
    }
    
    //zárási idő mentése
    async saveEndTime(projectEnd) {
        if (!this.currentProjectTimeId) {
            console.error("Nincs projectTime ID a mentéshez!");
            return;
        }
    
        try {
            await updateProjectTime(this.currentProjectTimeId, { project_end: projectEnd.toISOString().slice(0, 19).replace("T", " ") });
            console.log("Idősáv vége mentve:", projectEnd);
        } catch (error) {
            console.error("Hiba történt az idősáv mentésekor:", error);
        }
    }

    //comment mentése
    async saveComment() {
        const comment = this.commentElement.value;
        if (!this.currentProjectTimeId) {
            console.error("Nincs projectTime ID a komment mentéséhez!");
            return;
        }

        try {
            await updateProjectTime(this.currentProjectTimeId, { project_comment: comment });
            console.log("Komment mentve:", comment);
        } catch (error) {
            console.error("Hiba történt a komment mentésekor:", error);
        }
    }

    //gombok disabled állapotának kezelése
    updateButtonStates() {
        const startButton = document.getElementById("start-button");
        const stopButton = document.getElementById("stop-button");
    
        if (this.timerInterval) {
            startButton.disabled = true;
            stopButton.disabled = false;
        } else {
            startButton.disabled = false;
            stopButton.disabled = true;
        }
    }    

    // Dialog zárása
    closeDialog() {
        if (this.timerState) {
            this.stopTimer(); // Ha az időzítő fut hívjuk meg a stopTimer-t
        }

        this.dialogElement.style.display = "none"; // Elrejtjük a dialogot
    }
}

document.addEventListener("DOMContentLoaded", () => {
    // Projektekhez Tartozó Dialógus
    const dialog = document.getElementById("dialog");
    const buttons = document.querySelectorAll("#open-dialog-button");

    buttons.forEach((button) => {
        button.addEventListener("click", async () => {
            const projectId = button.dataset.projectId;
            const projectName = button.textContent;

            // Állítsuk be a modal elemeit
            const modal = new ProjectModal(projectId);
            await modal.init();

            // Beállítjuk a projekt nevét
            const projectNameElement = document.getElementById("project-name");
            projectNameElement.textContent = projectName;

            // Megjelenítjük a dialogot
            dialog.style.display = "block";
        });
    });

    // Export Dialógus Kezelése
    const openExportButton = document.getElementById('open-export-dialog');
    const exportDialog = document.getElementById('export-dialog');
    const exportContent = document.getElementById('export-content');
    const closeExportButton = document.getElementById('close-export-dialog');

    // Export gomb kattintás
    openExportButton.addEventListener('click', async () => {
        try {
            const html = await exportProjects(); // AJAX függvény meghívása
            if (html) {
                exportContent.innerHTML = html; // Tartalom betöltése a dialogba
                exportDialog.style.display = 'block'; // Dialog megjelenítése
            } else {
                console.error('Hiba: Az exportált tartalom üres.');
            }
        } catch (error) {
            console.error('Hiba történt az exportálás során:', error);
        }
    });

    // Dialógus bezárása
    closeExportButton.addEventListener('click', () => {
        exportDialog.style.display = 'none'; // Dialógus elrejtése
        exportContent.innerHTML = ''; // Tartalom ürítése
    });
});

