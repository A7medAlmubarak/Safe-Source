const autocannon = require('autocannon');

const test = autocannon({
  url: 'http://127.0.0.1:8000',
  connections: 10,  // Reduced connections for testing
  duration: 30,
  requests: [
    {
      method: 'POST',
      path: '/api/login',  // Verify this matches your route
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      body: JSON.stringify({
        email: 'test@example.com',
        password: 'password123'
      })
    }
  ]
});

// Log every request attempt
test.on('request', () => {
  console.log('Request sent');
});

// Log connection attempts
test.on('connect', () => {
  console.log('Connection established');
});

// Log responses (even errors)
test.on('response', (client, statusCode, resBytes, responseTime) => {
  console.log(`Response received - Status: ${statusCode}`);
});

// Detailed error logging
test.on('error', (err) => {
  console.error('Test error:', err);
});

// Track progress
autocannon.track(test);

// Final results
test.on('done', (results) => {
  console.log('\n=== Detailed Results ===');
  
  // Connection Info
  console.log('\nConnection Information:');
  console.log(`- Total Connections: ${results.connections}`);
  console.log(`- Total Errors: ${results.errors}`);
  console.log(`- Total Timeouts: ${results.timeouts}`);
  
  // Request Stats
  console.log('\nRequest Information:');
  console.log(`- Requests Sent: ${results.requests.sent}`);
  console.log(`- Requests Completed: ${results.requests.total}`);
  console.log(`- Failed Requests: ${results.non2xx}`);
  
  // Response Codes
  console.log('\nResponse Code Breakdown:');
  console.log(`- 2xx: ${results['2xx']}`);
  console.log(`- 3xx: ${results['3xx']}`);
  console.log(`- 4xx: ${results['4xx']}`);
  console.log(`- 5xx: ${results['5xx']}`);
  
  // Performance Metrics
  if (results.latency.average > 0) {
    console.log('\nPerformance Metrics:');
    console.log(`- Average Latency: ${results.latency.average}ms`);
    console.log(`- Min Latency: ${results.latency.min}ms`);
    console.log(`- Max Latency: ${results.latency.max}ms`);
  }
  
  // Warnings
  if (results.errors > 0 || results.timeouts > 0) {
    console.log('\n⚠️ Warning: Test encountered issues!');
  }
}); 