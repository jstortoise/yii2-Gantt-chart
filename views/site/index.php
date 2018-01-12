<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<style>
    .container {
        width: 80%;
        margin: 0 auto;
    }
    .gantt-container {
        overflow: scroll;
    }
    /* custom class */
    .gantt .bar-milestone .bar-progress {
        fill: tomato;
    }
</style>
<script src="/js/moment/min/moment.min.js"></script>
<script src="/js/snapsvg/dist/snap.svg-min.js"></script>
<script src="/js/frappe-gantt/dist/frappe-gantt.js"></script>
<div class="container">
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8">
            <div class="gantt-container">
                <svg id="gantt" width="400" height="600"></svg>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4">
            <h3>Redesign website</h3>
            <div class="input-group mb-3">
                <label>Start Date</label>
                <input type="date" class="form-control" aria-label="Username" aria-describedby="basic-addon1" id="start_date">
            </div>
            <div class="input-group mb-3">
                <label>Duration (days)</label>
                <input type="text" class="form-control" aria-label="Username" aria-describedby="basic-addon1" id="duration">
            </div>
        </div>
    </div>
</div>
<script>
    var names = [
        ["Redesign website", [0, 7]],
        ["Write new content", [1, 4]],
        ["Apply new styles", [3, 6]],
        ["Review", [7, 7]],
        ["Deploy", [8, 9]],
        ["Go Live!", [10, 10]]
    ];

    var tasks = names.map(function(name, i) {
        var today = new Date();
        var start = new Date(today.getFullYear(), today.getMonth(), today.getDate());
        var end = new Date(today.getFullYear(), today.getMonth(), today.getDate());
        start.setDate(today.getDate() + name[1][0]);
        end.setDate(today.getDate() + name[1][1]);
        return {
            start: start,
            end: end,
            name: name[0],
            id: "Task " + i,
            progress: parseInt(Math.random() * 100, 10)
        }
    });
    tasks[1].progress = 0;
    tasks[1].dependencies = "Task 0"
    tasks[2].dependencies = "Task 1"
    tasks[3].dependencies = "Task 2"
    tasks[5].dependencies = "Task 4"
    tasks[5].custom_class = "bar-milestone";

    var gantt_chart = Gantt("#gantt", tasks, {
        on_click: function (task) {
            document.getElementById("start_date").value = convertDate(task.start);
            document.getElementById("duration").value = getDuration(task.start, task.end);
            console.log(task);
        },
        on_date_change: function(task, start, end) {
            console.log(task, start, end);
        },
        on_progress_change: function(task, progress) {
            console.log(task, progress);
        },
        on_view_change: function(mode) {
            console.log(mode);
        }
    });

    function convertDate(date) {
        var yyyy = date.getFullYear().toString();
        var mm = (date.getMonth()+1).toString();
        var dd  = date.getDate().toString();

        var mmChars = mm.split('');
        var ddChars = dd.split('');

        return yyyy + '-' + (mmChars[1]?mm:"0"+mmChars[0]) + '-' + (ddChars[1]?dd:"0"+ddChars[0]);
    }

    function getDuration(sdate, edate) {
        var timeDiff = Math.abs(edate.getTime() - sdate.getTime());
        var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)); 
        return diffDays + 1;
    }

</script>
