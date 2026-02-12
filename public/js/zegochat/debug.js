/**
 * Debug Helper for ZegoCloud Messenger
 * This file helps identify issues with the messenger
 */

(function() {
    'use strict';

    console.log('=================================================');
    console.log('ZegoCloud Messenger Debug');
    console.log('=================================================');

    // Check meta tags
    console.log('\n1. Checking Meta Tags:');
    console.log('-----------------------------------');
    const userId = document.querySelector('meta[name="user-id"]')?.content;
    const userName = document.querySelector('meta[name="user-name"]')?.content;
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

    console.log('User ID:', userId || '❌ MISSING');
    console.log('User Name:', userName || '❌ MISSING');
    console.log('CSRF Token:', csrfToken ? '✅ Present' : '❌ MISSING');

    if (!userId) {
        console.error('❌ ERROR: User ID is missing! User might not be logged in.');
    }

    // Check ZIM SDK
    console.log('\n2. Checking ZIM SDK:');
    console.log('-----------------------------------');
    if (typeof ZIM !== 'undefined') {
        console.log('✅ ZIM SDK loaded');
        console.log('ZIM version:', ZIM.getVersion?.() || 'Unknown');
    } else {
        console.error('❌ ERROR: ZIM SDK not loaded!');
        console.error('Make sure the script tag is present:');
        console.error('<script src="https://unpkg.com/zego-zim-web@latest/index.js"></script>');
    }

    // Check jQuery
    console.log('\n3. Checking jQuery:');
    console.log('-----------------------------------');
    if (typeof jQuery !== 'undefined') {
        console.log('✅ jQuery loaded (version:', jQuery.fn.jquery, ')');
    } else {
        console.error('❌ ERROR: jQuery not loaded!');
    }

    // Check DOM elements
    console.log('\n4. Checking DOM Elements:');
    console.log('-----------------------------------');
    const elements = {
        'Connection Status': document.getElementById('connectionStatus'),
        'Contacts List': document.getElementById('contactsList'),
        'Chat Messages': document.getElementById('chatMessages'),
        'Message Input': document.getElementById('messageInput'),
        'Message Form': document.getElementById('messageForm'),
    };

    Object.entries(elements).forEach(([name, el]) => {
        console.log(`${name}:`, el ? '✅ Found' : '❌ Missing');
    });

    // Test token endpoint
    console.log('\n5. Testing Token Endpoint:');
    console.log('-----------------------------------');

    if (!userId) {
        console.error('⏭️  Skipping token test (user not logged in)');
    } else {
        fetch('/zego/get-token', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => {
            console.log('Status:', response.status, response.statusText);
            return response.json();
        })
        .then(data => {
            console.log('Response:', data);

            if (data.success) {
                console.log('✅ Token endpoint working!');
                console.log('App ID:', data.app_id);
                console.log('Token length:', data.token?.length);

                // Test ZIM initialization
                if (typeof ZIM !== 'undefined') {
                    console.log('\n6. Testing ZIM Initialization:');
                    console.log('-----------------------------------');

                    try {
                        ZIM.create({ appID: data.app_id });
                        const zimInstance = ZIM.getInstance();

                        if (zimInstance) {
                            console.log('✅ ZIM instance created');

                            const userInfo = {
                                userID: String(userId),
                                userName: userName || 'User'
                            };

                            zimInstance.login(userInfo, data.token)
                                .then(() => {
                                    console.log('✅ ZIM login successful!');
                                    console.log('🎉 Everything is working correctly!');
                                })
                                .catch(err => {
                                    console.error('❌ ZIM login failed:', err);
                                    console.error('Error code:', err.code);
                                    console.error('Error message:', err.message);

                                    if (err.code === 6000103) {
                                        console.error('💡 This is a token validation error.');
                                        console.error('Possible causes:');
                                        console.error('1. Wrong App ID or Server Secret');
                                        console.error('2. Token format is incorrect');
                                        console.error('3. ZegoCloud project settings issue');
                                    }
                                });
                        } else {
                            console.error('❌ Failed to get ZIM instance');
                        }
                    } catch (err) {
                        console.error('❌ Error creating ZIM instance:', err);
                    }
                }
            } else {
                console.error('❌ Token endpoint returned error:', data.message);
            }
        })
        .catch(err => {
            console.error('❌ Failed to fetch token:', err);
        });
    }

    console.log('\n=================================================');
    console.log('Debug information complete');
    console.log('Check the console output above for any ❌ errors');
    console.log('=================================================\n');

})();
