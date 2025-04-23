document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    function fetchDashboardData() {
        fetch('/RHU-Dashboard-Fetch', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Unable to fetch data from the database' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
           
            // Total number of Patient for the current month
            const Total = document.getElementById('Total');
            const TotalCount = data.TotalForThisMonth;
            Total.innerText = TotalCount;

            // Display Highest Consultation and its Number of Patients
            const HighestConsultationArea = document.getElementById('HighestConsultationArea');
            HighestConsultationArea.innerHTML = '';

            if (data.HighestConsul && data.HighestConsul.length > 0 && data.HighestConsul[0].Consultation && data.HighestConsultationValue && data.HighestConsultationValue !== 0) {
                HighestConsultationArea.insertAdjacentHTML('beforeend', `
                  
                        <span class="HighestConsultation us:text-tiny us:font-semibold font-font-Arial us:m-2 x:text-lg md:text-lg">Current Highest</span>
                    
    
                    
                        <span class="HighestConsultation  us:text-md us:font-semibold font-font-Arial us:mx-2 x:text-2xl md:text-2xl">
                            ${data.HighestConsul[0].Consultation}
                        </span>
                        <span class="HighestConsultationPercentage  us:text-md us:font-semibold font-font-Arial us:mx-2 x:text-2xl md:text-2xl">
                            Patients: ${data.HighestConsultationValue}        
                        </span>
                 
                `);
            } else {
                HighestConsultationArea.insertAdjacentHTML('beforeend', `

                        <span class="HighestConsultation us:text-tiny us:font-semibold font-font-Arial us:m-2 x:text-lg md:text-lg">Current Highest</span>
                 
    

                        <span class="HighestConsultation us:text-md us:font-semibold font-font-Arial us:mx-2 x:text-2xl md:text-2xl">
                            No Data
                        </span>
                        <span class="HighestConsultationPercentage us:text-md us:font-semibold font-font-Arial us:mx-2 x:text-2xl md:text-2xl">
                            Patients: 0  
                        </span>

                `);
            }

            // Compare Current Highest To Past Record
            // console.log(data.HighestConsultationValue);  
            if (data.PrevDataOfCurrentHighestData === 0) {
                HighestConsultationArea.insertAdjacentHTML('beforeend', `
                    <span class=" us:text-tiny us:font-semibold font-font-Arial us:m-2 x:text-sm md:text-sm">
                      No Data
                    </span>    
               
                `);
            }
            else if (data.PrevDataOfCurrentHighestData < data.HighestConsultationValue) {
            HighestConsultationArea.insertAdjacentHTML('beforeend', `
           
                <span class=" us:text-tiny us:font-semibold font-font-Arial us:m-2 x:text-sm md:text-sm">
                   There is an increase in case
                   ${Number(Math.abs(data.HighConsulDiff)).toFixed(0)}%
                </span>    
         
             `);
            } 
            else if (data.PrevDataOfCurrentHighestData > data.HighestConsultationValue) {
            HighestConsultationArea.insertAdjacentHTML('beforeend', `
            
                <span class=" us:text-tiny us:font-semibold font-font-Arial us:m-2 x:text-sm md:text-sm">
                    There is decrease in case
                     ${Number(Math.abs(data.HighConsulDiff)).toFixed(0)}%
                </span>    
          
            `);
            } 
            else if (data.PrevDataOfCurrentHighestData === data.HighestConsultationValue) {
            HighestConsultationArea.insertAdjacentHTML('beforeend', `
            
                 <span class=" us:text-tiny us:font-semibold font-font-Arial us:m-2 x:text-sm md:text-sm">
                   There is no increase or decrease in cases.
                 </span>    
            
            `);
            }
            else if (data.HighestConsultationValue === 0) {
            HighestConsultationArea.insertAdjacentHTML('beforeend', `
            
                <span class=" us:text-tiny us:font-semibold font-font-Arial us:m-2 x:text-sm md:text-sm">
                    No Data
                </span>    
           
            `);
            }
        
            // Display Lowest Consultation and its Number of Patients
            const LowestConsultationArea = document.getElementById('LowestConsultationArea');
            LowestConsultationArea.innerHTML = '';
            // console.log(data.LowestConsultationValue);
            if (data.LowestConsul && data.LowestConsul.length > 0 && data.LowestConsul[0].Consultation && data.LowestConsultationValue && data.LowestConsultationValue !== 0) {
                LowestConsultationArea.insertAdjacentHTML('beforeend', `
                    
                        <span class="LowestConsultation us:text-tiny us:font-semibold font-font-Arial us:m-2 x:text-lg md:text-lg">Current Lowest</span>
                   
    
                    
                        <span class="LowestConsultation us:text-md us:font-semibold font-font-Arial us:mx-2 x:text-2xl md:text-2xl">
                            ${data.LowestConsul[0].Consultation}
                        </span>
                        <span class="LowestConsultationPercentage us:text-md us:font-semibold font-font-Arial us:mx-2 x:text-2xl md:text-2xl">
                            Patients: ${data.LowestConsultationValue}        
                        </span>
                    
                `);
            } else {
                LowestConsultationArea.insertAdjacentHTML('beforeend', `
                   
                        <span class="LowestConsultation us:text-tiny us:font-semibold font-font-Arial us:m-2 x:text-lg md:text-lg">Current Lowest</span>
                   

                  
                        <span class="LowestConsultation us:text-md us:font-semibold font-font-Arial us:mx-2 x:text-2xl md:text-2xl">
                            No Data
                        </span>
                        <span class="LowestConsultationPercentage us:text-md us:font-semibold font-font-Arial us:mx-2 x:text-2xl md:text-2xl">
                            Patients: 0
                        </span>
                 
                `);
            }
            // Compare Current Lowest To Past Record
            // console.log(data.PrevDataOfCurrentLowestData);  
            if (data.PrevDataOfCurrentLowestData === 0) {
                LowestConsultationArea.insertAdjacentHTML('beforeend', `
              
                    <span class=" us:text-tiny us:font-semibold font-font-Arial us:m-2 x:text-sm md:text-sm">
                      No Data
                    </span>    

                `);
            }
            else if (data.PrevDataOfCurrentLowestData < data.LowestConsultationValue) {
                LowestConsultationArea.insertAdjacentHTML('beforeend', `
        
                <span class=" us:text-tiny us:font-semibold font-font-Arial us:m-2 x:text-sm md:text-sm">
                   There is an increase in case
                   ${Number(Math.abs(data.LowConsulDiff)).toFixed(0)}%
                </span>    

             `);
            } 
            else if (data.PrevDataOfCurrentLowestData > data.LowestConsultationValue) {
            LowestConsultationArea.insertAdjacentHTML('beforeend', `
             
                <span class=" us:text-tiny us:font-semibold font-font-Arial us:m-2 x:text-sm md:text-sm">
                    There is decrease in case
                     ${Number(Math.abs(data.LowConsulDiff)).toFixed(0)}%
                </span>    
          
            `);
            } 
            else if (data.PrevDataOfCurrentLowestData === data.LowestConsultationValue) {
            LowestConsultationArea.insertAdjacentHTML('beforeend', `
           
                 <span class=" us:text-tiny us:font-semibold font-font-Arial us:m-2 x:text-sm md:text-sm">
                   There is no increase or decrease in cases.
                 </span>    
            
            `);
            }
            else if (data.LowestConsultationValue === 0) {
            LowestConsultationArea.insertAdjacentHTML('beforeend', `

                <span class=" us:text-tiny us:font-semibold font-font-Arial us:m-2 x:text-sm md:text-sm">
                    No Data
                </span>    
            `);
            }

        // Table Area Label
        const BreakDownLabel = document.getElementById('BreakDownLabel');
        BreakDownLabel.innerHTML = '';
            var row = `
              <tr class="">
                <th class=" us:text-tiny us:font-semibold font-font-Arial us:m-2 x:text-sm md:text-sm">Consultation</th>
                <th class=" us:text-tiny us:font-semibold font-font-Arial us:m-2 x:text-sm md:text-sm">Total Number of Patient</th>
                <th class=" us:text-tiny us:font-semibold font-font-Arial us:m-2 x:text-sm md:text-sm">Male</th>
                <th class=" us:text-tiny us:font-semibold font-font-Arial us:m-2 x:text-sm md:text-sm">Senior Male</th>
                <th class=" us:text-tiny us:font-semibold font-font-Arial us:m-2 x:text-sm md:text-sm">Adult Male</th>
                <th class=" us:text-tiny us:font-semibold font-font-Arial us:m-2 x:text-sm md:text-sm">Teen Male</th>
                <th class=" us:text-tiny us:font-semibold font-font-Arial us:m-2 x:text-sm md:text-sm">Child Male</th>
                <th class=" us:text-tiny us:font-semibold font-font-Arial us:m-2 x:text-sm md:text-sm">Female</th>
                <th class=" us:text-tiny us:font-semibold font-font-Arial us:m-2 x:text-sm md:text-sm">Senior Female</th>
                <th class=" us:text-tiny us:font-semibold font-font-Arial us:m-2 x:text-sm md:text-sm">Adult Female</th>
                <th class=" us:text-tiny us:font-semibold font-font-Arial us:m-2 x:text-sm md:text-sm">Teen Female</th>
                <th class=" us:text-tiny us:font-semibold font-font-Arial us:m-2 x:text-sm md:text-sm">Child Female</th>
            </tr>
            `;
        BreakDownLabel.innerHTML = row;
        // Table Area Value
        // console.log(data)
        const BreakDown = document.getElementById('BreakDown');
        BreakDown.innerHTML = '';
            data.Data.forEach(function(List){
                var row = `
                <tr>
                <td class=" us:text-tiny us:font-semibold font-font-Arial us:m-2  x:text-sm md:text-sm"
                    <div class="">
                        ${List.Consultation}
                    </div>
                </td>
                <td class=" us:text-tiny us:font-semibold font-font-Arial us:m-2 x:text-sm md:text-sm">
                    <div class="">
                        ${List.NumPatient}
                    </div>
                </td> 



                <td class=" us:text-tiny us:font-semibold font-font-Arial us:m-2 x:text-sm md:text-sm">
                    <div class="">
                        ${List.NumMale}
                    </div>
                </td>   
                <td class=" us:text-tiny us:font-semibold font-font-Arial us:m-2 x:text-sm md:text-sm">
                    <div class=" ">
                        ${List.NumSeniorMale}
                    </div>
                </td>
                <td class=" us:text-tiny us:font-semibold font-font-Arial us:m-2 x:text-sm md:text-sm">
                    <div class=" ">
                        ${List.NumAdultMale}
                    </div>
                </td>                
                <td class=" us:text-tiny us:font-semibold font-font-Arial us:m-2 x:text-sm md:text-sm">
                    <div class=" ">
                        ${List.NumTeenMale}
                    </div>
                </td>
                <td class=" us:text-tiny us:font-semibold font-font-Arial us:m-2 x:text-sm md:text-sm">
                    <div class=" ">
                        ${List.NumChildMale}
                    </div>
                </td>

                


                <td class=" us:text-tiny us:font-semibold font-font-Arial us:m-2 x:text-sm md:text-sm">
                    <div class=" ">
                        ${List.NumFemale}
                    </div>
                </td>
                <td class=" us:text-tiny us:font-semibold font-font-Arial us:m-2 x:text-sm md:text-sm">
                    <div class=" ">
                        ${List.NumSeniorFemale}
                    </div>
                </td>
                <td class=" us:text-tiny us:font-semibold font-font-Arial us:m-2 x:text-sm md:text-sm">
                    <div class=" ">
                        ${List.NumAdultFemale}
                    </div>
                </td>
                <td class=" us:text-tiny us:font-semibold font-font-Arial us:m-2 x:text-sm md:text-sm">
                    <div class=" ">
                        ${List.NumTeenFemale}
                    </div>
                </td>
                <td class=" us:text-tiny us:font-semibold font-font-Arial us:m-2 x:text-sm md:text-sm">
                    <div class=" ">
                        ${List.NumChildFemale}
                    </div>
                </td>
                `;
                BreakDown.innerHTML += row;
            
        
            // Google Chart  
            console.log(data.CurrentYearData);
            const ChartColumn = [['Month', 'NumPatient']];
            data.CurrentYearData.forEach(Value => {
                ChartColumn.push([Value.Month, Value.NumPatient]);
            });
            const ChartColumnData = google.visualization.arrayToDataTable(ChartColumn);
            var options = {
                title : 'Number of patients for each month.',
                vAxis: {title: 'Patients'},
                hAxis: {title: 'Month'},
                seriesType: 'bars',
                series: {5: {type: 'line'}},
                chartArea: { left: '6%', top: '30%', width: '100%', height: '50%' }
              };
      
              var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
              chart.draw(ChartColumnData, options);
            });
            // Pie Chart                      
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
                titleTextStyle: { color: 'black', fontName: 'Arial', fontSize: 18, italic: true, bold: true },

            };

            const chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
            chart.draw(pieChartData, options);
     
    })
        .catch(error => console.error(error));
    }
             
    // Initial fetch
    fetchDashboardData();

    setInterval(fetchDashboardData, 1000);
});
