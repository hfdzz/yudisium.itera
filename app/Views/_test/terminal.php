<?php
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yudisium Terminal</title>
    <style>
        /* make textarea like terminal */
        .terminal {
            width: 100%;
            height: 80vh;
            background-color: black;
            color: white;
            font-family: monospace;
            font-size: 16px;
            border: none;
            outline: none;
            display: flex;
            flex-direction: column;
            /* start from bottom */
            justify-content: flex-end;
        }

        .terminal input {
            width: 100%;
            background-color: white;
            color: black;
            font-family: monospace;
            font-size: 16px;
            border: none;
            outline: none;
            resize: none;
        }

        #terminal-output {
            padding: 10px;
            flex: 1;
            overflow-y: scroll;
        }

        .terminal-input {
            display: flex;
            align-items: center;
            padding: 10px;
            background-color: gray;
            color: white;
            font-family: monospace;
            font-size: 16px;
            border: none;
            outline: none;
            gap: 10px;
        }

        pre {
            margin: 0;
        }
    </style>
</head>
<body>
    <h1>Terminal</h1>
    <div class="terminal" id="terminal">
        <div id="terminal-output"></div>
        <form action="<?= route_to('test.terminal') ?>" method="post" id="terminal-form">
            <div class="terminal-input">
                <span>></span>
                <input type="text"name="command" id="command" autocomplete="off"/>
                <button type="submit">Submit</button>
            </div>
        </form>
    </div>

    <script>
        const terminalOutput = document.getElementById('terminal-output');
        const commandInput = document.getElementById('command');
        const terminalForm = document.getElementById('terminal-form');
        const terminal = document.getElementById('terminal');

        let waitingForResponse = false;

        window.onload = () => {
            commandInput.focus();
        }

        window.onkeydown = (e) => {
            // skip if terminal output is focused
            if (document.getSelection().toString() !== '') {
                return;
            }
            commandInput.focus();
            terminalOutput.scrollTop = terminalOutput.scrollHeight;
        }

        terminalForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const command = commandInput.value;
            if (!command) {
                return;
            }
            if (waitingForResponse) {
                return;
            }
            waitingForResponse = true;
            handleCommand(command);
            commandInput.value = '';
            commandInput.focus();
        });
        
        const handleCommand = async (command) => {
            terminalOutputText("<span>>&nbsp;</span>" + command);

            if (command === 'clear') {
                terminalOutput.innerHTML = '';
                return;
            }
            
            fetch(terminalForm.action, {
                method: "POST",
                body: new FormData(terminalForm),
            })
            .then((response) => {
                response.json().then(data => {
                    if (data.type === 'Error') {
                        terminalOutputText(data.output ?? data.message, true);
                        return;
                    }
                    let output = data.output;
                    terminalOutputText(output);
                })
                .catch(error => {
                    terminalOutputText('Error: ' + error.message, true);
                });
            })
            .catch(error => {
                terminalOutputText(error.message, true);
            })
            .finally(() => {
                waitingForResponse = false;
            });
            
        }
        
        const terminalOutputText = (text, error = false) => {
            const newEl = document.createElement('pre');
            newEl.innerHTML = text;
            if (error) {
                newEl.style.color = 'red';
            }
            let scroll = terminalOutput.scrollHeight - terminalOutput.clientHeight <= terminalOutput.scrollTop + 1;
            terminalOutput.appendChild(newEl);
            if (scroll) {
                terminalOutput.scrollTop = terminalOutput.scrollHeight;
            }
        }
        </script>
</body>
</html>