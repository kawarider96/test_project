<div id="dialog" 
     data-project-id="" 
     data-start-saved="false" 
     style="display: none; background-color: white; border: 1px solid black; position: relative; padding: 20px; max-width: 600px; margin: 0 auto;">
    
    <!-- Projekt neve -->
    <h1 id="project-name" style="text-align: center; text-transform: uppercase; margin-bottom: 20px;"></h1>

    <!-- Száláló -->
    <div id="timer" style="text-align: center; font-size: 2em; margin-bottom: 20px;">00:00:00</div>

    <!-- Megjegyzés -->
    <div style="text-align: center; margin-bottom: 20px;">
        <label for="project-comment">Projekt Megjegyzés:</label><br>
        <textarea id="project-comment" 
                  name="project_comment" 
                  rows="4" 
                  style="width: 90%;"></textarea>
    </div>

    <!-- Gombok -->
    <div style="text-align: center; margin-top: 20px;">
        <button id="start-button">Start</button>
        <button id="stop-button">Stop</button>
    </div>

    <!-- Bezárás gomb -->
    <button id="close-button" style="position: absolute; top: 10px; right: 10px;">X</button>
</div>
