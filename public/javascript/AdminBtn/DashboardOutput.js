document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Function to fetch and display the dashboard data
    function fetchDashboardData() {
        fetch('https://iptproject-idxs.onrender.com/RHU-Dashboard-Fetch', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Unable to fetch data from the database: ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            console.log('Fetched data:', data); // Log the data for inspection

            // Check if data is empty or malformed
            if (!data) {
                console.error('No data received');
                return;
            }

            // Total number of Patients for the current month
            const Total = document.getElementById('Total');
            if (Total) {
                const TotalCount = data.TotalForThisMonth || 'N/A';
                Total.innerText = TotalCount;
            }

            // Highest Consultation and its Number of Patients
            const HighestConsultationArea = document.getElementById('HighestConsultationArea');
            if (HighestConsultationArea) {
                HighestConsultationArea.innerHTML = '';

                const highestConsultation = data.HighestConsul && data.HighestConsul[0];
                const highestConsultationValue = data.HighestConsultationValue || 0;

                if (highestConsultation && highestConsultation.Consultation && highestConsultationValue > 0) {
                    HighestConsultationArea.insertAdjacentHTML('beforeend', `
                        <span class="HighestConsultation">Current Highest</span>
                        <span class="HighestConsultation">${highestConsultation.Consultation}</span>
                        <span class="HighestConsultationPercentage">Patients: ${highestConsultationValue}</span>
                    `);
                } else {
                    HighestConsultationArea.insertAdjacentHTML('beforeend', `
                        <span class="HighestConsultation">Current Highest</span>
                        <span class="HighestConsultation">No Data</span>
                        <span class="HighestConsultationPercentage">Patients: 0</span>
                    `);
                }

                // Compare current highest to past record
                const prevHighest = data.PrevDataOfCurrentHighestData || 0;
                if (prevHighest === 0) {
                    HighestConsultationArea.insertAdjacentHTML('beforeend', `
                        <span>No Data</span>
                    `);
                } else {
                    const diff = data.HighConsulDiff || 0;
                    if (prevHighest < highestConsultationValue) {
                        HighestConsultationArea.insertAdjacentHTML('beforeend', `
                            <span>There is an increase in case: ${Math.abs(diff).toFixed(0)}%</span>
                        `);
                    } else if (prevHighest > highestConsultationValue) {
                        HighestConsultationArea.insertAdjacentHTML('beforeend', `
                            <span>There is a decrease in case: ${Math.abs(diff).toFixed(0)}%</span>
                        `);
                    } else {
                        HighestConsultationArea.insertAdjacentHTML('beforeend', `
                            <span>There is no change in cases.</span>
                        `);
                    }
                }
            }

            // Lowest Consultation and its Number of Patients
            const LowestConsultationArea = document.getElementById('LowestConsultationArea');
            if (LowestConsultationArea) {
                LowestConsultationArea.innerHTML = '';

                const lowestConsultation = data.LowestConsul && data.LowestConsul[0];
                const lowestConsultationValue = data.LowestConsultationValue || 0;

                if (lowestConsultation && lowestConsultation.Consultation && lowestConsultationValue > 0) {
                    LowestConsultationArea.insertAdjacentHTML('beforeend', `
                        <span class="LowestConsultation">Current Lowest</span>
                        <span class="LowestConsultation">${lowestConsultation.Consultation}</span>
                        <span class="LowestConsultationPercentage">Patients: ${lowestConsultationValue}</span>
                    `);
                } else {
                    LowestConsultationArea.insertAdjacentHTML('beforeend', `
                        <span class="LowestConsultation">Current Lowest</span>
                        <span class="LowestConsultation">No Data</span>
                        <span class="LowestConsultationPercentage">Patients: 0</span>
                    `);
                }

                // Compare current lowest to past record
                const prevLowest = data.PrevDataOfCurrentLowestData || 0;
                if (prevLowest === 0) {
                    LowestConsultationArea.insertAdjacentHTML('beforeend', `
                        <span>No Data</span>
                    `);
                } else {
                    const diff = data.LowConsulDiff || 0;
                    if (prevLowest < lowestConsultationValue) {
                        LowestConsultationArea.insertAdjacentHTML('beforeend', `
                            <span>There is an increase in case: ${Math.abs(diff).toFixed(0)}%</span>
                        `);
                    } else if (prevLowest > lowestConsultationValue) {
                        LowestConsultationArea.insertAdjacentHTML('beforeend', `
                            <span>There is a decrease in case: ${Math.abs(diff).toFixed(0)}%</span>
                        `);
                    } else {
                        LowestConsultationArea.insertAdjacentHTML('beforeend', `
                            <span>There is no change in cases.</span>
                        `);
                    }
                }
            }

            // Table Area: Consultation Breakdown
            const BreakDownLabel = document.getElementById('BreakDownLabel');
            if (BreakDownLabel) {
                const row = `
                    <tr>
                        <th>Consultation</th>
                        <th>Total Number of Patient</th>
                        <th>Male</th>
                        <th>Senior Male</th>
                        <th>Adult Male</th>
                        <th>Teen Male</th>
                        <th>Child Male</th>
                        <th>Female</th>
                        <th>Senior Female</th>
                        <th>Adult Female</th>
                        <th>Teen Female</th>
                        <th>Child Female</th>
                    </tr>
                `;
                BreakDownLabel.innerHTML = row;
            }

            const BreakDown = document.getElementById('BreakDown');
            if (BreakDown) {
                BreakDown.innerHTML = '';
                data.Data.forEach(function(List) {
                    const row = `
                    <tr>
                        <td>${List.Consultation}</td>
                        <td>${List.NumPatient}</td>
                        <td>${List.NumMale}</td>
                        <td>${List.NumSeniorMale}</td>
                        <td>${List.NumAdultMale}</td>
                        <td>${List.NumTeenMale}</td>
                        <td>${List.NumChildMale}</td>
                        <td>${List.NumFemale}</td>
                        <td>${List.NumSeniorFemale}</td>
                        <td>${List.NumAdultFemale}</td>
                        <td>${List.NumTeenFemale}</td>
                        <td>${List.NumChildFemale}</td>
                    </tr>
                    `;
                    BreakDown.innerHTML += row;
                });
            }

            // Google Charts: Column Chart (Yearly)
            if (data.CurrentYearData) {
                const ChartColumn = [['Month', 'NumPatient']];
                data.CurrentYearData.forEach(Value => {
                    ChartColumn.push([Value.Month, Value.NumPatient]);
                });
                const ChartColumnData = google.visualization.arrayToDataTable(ChartColumn);
                const options = {
                    title: 'Number of patients for each month.',
                    vAxis: { title: 'Patients' },
                    hAxis: { title: 'Month' },
                    seriesType: 'bars',
                    series: { 5: { type: 'line' } },
                    chartArea: { left: '6%', top: '30%', width: '100%', height: '50%' }
                };
                const chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
                chart.draw(ChartColumnData, options);
            }

            // Google Charts: Pie Chart
            if (data.Pie) {
                const pieChartDataArray = [['Consultation', 'NumPatient']];
                data.Pie.forEach(Value => {
                    pieChartDataArray.push([Value.Consultation, Value.NumPatient]);
                });
                const pieChartData = google.visualization.arrayToDataTable(pieChartDataArray);
                const options = {
                    is3D: true,
                    backgroundColor: { fill: 'transparent' },
                    legend: 'none',
                    pieStartAngle: 90,
                    chartArea: { left: '5%', top: '0', width: '85%', height: '75%' },
                    titleTextStyle: { color: 'black', fontName: 'Arial', fontSize: 18, italic: true, bold: true }
                };
                const chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
                chart.draw(pieChartData, options);
            }

        })
        .catch(error => {
            console.error('Error fetching dashboard data:', error);
        });
    }

    // Initial fetch
    fetchDashboardData();
});
